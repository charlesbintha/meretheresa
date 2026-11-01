"""Read the source workbook only; create a private, traceable import manifest."""
import argparse, collections, datetime, hashlib, json, os
import openpyxl

def norm(v): return ' '.join(str(v or '').upper().split())
def prepare(path):
    w=openpyxl.load_workbook(path,data_only=True)
    def people(s):return [r for r in range(2,s.max_row+1) if s.cell(r,3).value and s.cell(r,4).value]
    def v(s,r,c):return s.cell(r,c).value
    base=w['CLASSE']; index=collections.defaultdict(list)
    for r in people(base):index[str(v(base,r,1))].append(r)
    result={'format':1,'year':'2026-2027','sourceHash':hashlib.sha256(open(path,'rb').read()).hexdigest(),'students':[],'excluded':[],'corrections':[]}
    def date(s,r,col):
        raw=v(s,r,col);where=f'{s.title}!{s.cell(r,col).coordinate}'
        if raw is None:return None,None
        if isinstance(raw,datetime.datetime):
            d=raw.date()
            if d.year==2029:d=d.replace(year=2026)
            if d==datetime.date(1900,1,2):d=datetime.date(2026,10,2)
            if str(d)!=str(raw.date()):result['corrections'].append({'cell':where,'before':str(raw.date()),'after':str(d)})
            if d.year not in (2026,2027):return None,str(raw.date())
            return str(d),None
        return None,str(raw)
    def amount(s,r,c):
        a=v(s,r,c)
        if a in (None,''):return 0
        if not isinstance(a,(int,float)) or a<0 or int(a)!=a:raise ValueError(f'Montant invalide : {s.title}!{s.cell(r,c).coordinate}')
        return int(a)
    def receipt(s,r,a,d,ref,kind,month,label=None):
        amt=amount(s,r,a)
        if not amt:return None
        paid,raw=date(s,r,d)
        return {'kind':kind,'month':month,'label':label or kind,'amount':amt,'date':paid,'rawDate':raw,'reference':str(v(s,r,ref)).strip() if v(s,r,ref) else None,'source':f'{s.title}!{s.cell(r,a).coordinate}'}
    targets={}
    for r in people(base):
        order=v(base,r,1)
        if order==678:result['excluded'].append({'sheet':'CLASSE','row':r,'order':order,'reason':'Matricule 678 exclu sur demande'});continue
        if not isinstance(order,int) or len(index[str(order)])!=1:raise ValueError(f'Matricule ambigu CLASSE ligne {r}')
        schoolclass=norm(v(base,r,2)); assert schoolclass in ['GARDE','PS','MS','GS','CI','CP','CE1','CE2','CM1','CM2']
        enrolled,raw=date(base,r,10)
        student={'order':order,'class':schoolclass,'lastName':str(v(base,r,3)).strip(),'firstName':str(v(base,r,4)).strip(),'date':enrolled,'rawDate':raw,'sourceRow':r,'receipts':[],'subscriptions':[]}
        for c,label in [(5,'Frais généraux'),(6,'Tenue / blouse'),(7,'Sport'),(8,'Tenue / sport supplémentaire'),(9,'Scolarité octobre')]:
            rec=receipt(base,r,c,10,11,'supplement' if c==8 else 'tuition' if c==9 else 'registration','2026-10',label)
            if rec:student['receipts'].append(rec)
        for i,c in enumerate([13,20,27,34,41,48,55,62]):
            m=11+i;month=f'{2026+(m-1)//12}-{(m-1)%12+1:02d}'
            for a,kind in [(c,'tuition')]+([(c+3,'studies')] if i<7 else []):
                rec=receipt(base,r,a,a+1,a+2,kind,month)
                if rec:student['receipts'].append(rec)
        student['sourceRegistrationBalance']=v(base,r,12)
        targets[str(order)]=student;result['students'].append(student)
    for name in ['CANTINE','TRANSPORT']:
        s=w[name]
        for r in people(s):
            order=str(v(s,r,1));target=targets.get(order)
            reason=None
            if not target:reason='Matricule exclu ou absent de CLASSE'
            elif (norm(v(s,r,3)),norm(v(s,r,4)))!=(norm(target['lastName']),norm(target['firstName'])):reason='Identité différente de CLASSE pour ce matricule'
            elif name=='TRANSPORT' and norm(v(s,r,6)) in ['ABD','']:reason='Zone exclue ou absente' if norm(v(s,r,5))=='OUI' else None
            if reason:
                result['excluded'].append({'sheet':name,'row':r,'order':order,'reason':reason});continue
            if norm(v(s,r,5))!='OUI':continue
            kind='canteen' if name=='CANTINE' else 'transport';zone=None;trip='round_trip'
            if kind=='transport':
                zone=norm(v(s,r,6));trip='return' if 'RETOUR' in zone else 'outbound' if 'ALLER' in zone else 'round_trip';zone=zone.replace(' RETOUR','').replace(' ALLER','')
                if zone not in ['ZONE 1','ZONE 2','ZONE 3','HORS ZONE']:raise ValueError(f'Zone inconnue {s.title}!F{r}')
            target['subscriptions'].append({'kind':kind,'zone':zone,'trip':trip,'source':f'{name}!E{r}'})
            start=7 if kind=='canteen' else 9;last=31 if kind=='canteen' else 41
            # Adhesion uses first month's receipt metadata; missing fields remain flagged.
            rec=receipt(s,r,6 if kind=='canteen' else 8,start+1,start+2,kind+'_adhesion','2026-11' if kind=='canteen' else '2026-10')
            if rec:target['receipts'].append(rec)
            for i,c in enumerate(range(start,last+1,4)):
                m=(11 if kind=='canteen' else 10)+i;month=f'{2026+(m-1)//12}-{(m-1)%12+1:02d}'
                rec=receipt(s,r,c,c+1,c+2,kind,month)
                if rec:target['receipts'].append(rec)
    return result
if __name__=='__main__':
    p=argparse.ArgumentParser();p.add_argument('workbook');p.add_argument('output');a=p.parse_args();data=prepare(a.workbook)
    os.makedirs(os.path.dirname(os.path.abspath(a.output)),exist_ok=True)
    with open(a.output,'w') as f:json.dump(data,f,ensure_ascii=False,indent=2)
    os.chmod(a.output,0o600)
    print(json.dumps({'students':len(data['students']),'receipts':sum(len(s['receipts']) for s in data['students']),'subscriptions':dict(collections.Counter(t['kind'] for s in data['students'] for t in s['subscriptions'])),'exclusions':dict(collections.Counter((x['sheet']+': '+x['reason']) for x in data['excluded'])),'dateCorrections':len(data['corrections'])},ensure_ascii=False,indent=2))
