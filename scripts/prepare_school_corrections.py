"""Prepare additive corrections from user decisions; never rewrite the workbook."""
import argparse, collections, csv, hashlib, json, os
import openpyxl
from prepare_school_import import prepare, norm

def prepare_corrections(workbook, decisions):
    original=prepare(workbook)
    rows=list(csv.DictReader(open(decisions,encoding='utf-8-sig'),delimiter='\t'))
    expected={(r['sheet'],r['row']) for r in original['excluded']}
    actual=[(r['Feuille'],int(r['Ligne'])) for r in rows]
    if set(actual)!=expected or len(actual)!=len(set(actual)):raise ValueError('La liste doit traiter exactement les exclusions du premier import.')
    w=openpyxl.load_workbook(workbook,data_only=True);base=w['CLASSE'];overrides={};services={};abandoned=[];staff=[];audit=[]
    names=collections.defaultdict(list)
    for r in range(2,499):names[(norm(base.cell(r,3).value),norm(base.cell(r,4).value))].append(r)
    for d in rows:
        sheet=d['Feuille'];r=int(d['Ligne']);s=w[sheet];decision=d['Correction / décision'].strip()
        if (norm(d['Nom']),norm(d['Prénom']))!=(norm(s.cell(r,3).value),norm(s.cell(r,4).value)):raise ValueError('Identité source différente : '+sheet+str(r))
        info={'sheet':sheet,'row':r,'decision':decision}
        if decision.isdigit():
            overrides.setdefault(sheet,{})[r]=int(decision);info['order']=int(decision)
        elif sheet=='CANTINE' and 'personnel' in decision:
            staff.append({'firstName':str(s.cell(r,4).value).strip(),'lastName':str(s.cell(r,3).value).strip(),'role':str(s.cell(r,2).value or '').strip(),'source':f'CANTINE!C{r}','monthlyFee':6000})
        elif decision=='retirer du fichier':info['excluded']=True
        elif sheet=='TRANSPORT':
            match=names[(norm(d['Nom']),norm(d['Prénom']))]
            if len(match)!=1:raise ValueError(f'Identité ambiguë TRANSPORT!{r}: {match}')
            order=base.cell(match[0],1).value;services.setdefault(sheet,{})[r]=order;info['order']=order
            info['subscribed']=norm(s.cell(r,5).value)=='OUI'
            if 'abandon' in decision:abandoned.append(r)
        else:raise ValueError('Décision non reconnue : '+decision)
        audit.append(info)
    full=prepare(workbook,overrides,services,abandoned)
    prior={s['order']:s for s in original['students']};new=[];updates=[]
    for s in full['students']:
        if s['order'] not in prior:new.append(s);continue
        old=prior[s['order']];old_sources={r['source'] for r in old['receipts']}
        subscriptions=[t for t in s['subscriptions'] if t not in old['subscriptions']]
        receipts=[r for r in s['receipts'] if r['source'] not in old_sources]
        if subscriptions or receipts:updates.append({k:s[k] for k in ['order','firstName','lastName','class']}|{'subscriptions':subscriptions,'receipts':receipts})
    return {'format':2,'year':'2026-2027','sourceHash':original['sourceHash'],'correctionHash':hashlib.sha256(open(decisions,'rb').read()).hexdigest(),'students':new,'services':updates,'staff':staff,'decisions':audit}
if __name__=='__main__':
    p=argparse.ArgumentParser();p.add_argument('workbook');p.add_argument('decisions');p.add_argument('output');a=p.parse_args();data=prepare_corrections(a.workbook,a.decisions)
    with open(a.output,'w') as f:json.dump(data,f,ensure_ascii=False,indent=2)
    os.chmod(a.output,0o600)
    print(json.dumps({'students':len(data['students']),'serviceRecords':len(data['services']),'staff':len(data['staff']),'receipts':sum(len(s['receipts']) for s in data['students']+data['services']),'received':sum(r['amount'] for s in data['students']+data['services'] for r in s['receipts']),'decisions':len(data['decisions'])}))
