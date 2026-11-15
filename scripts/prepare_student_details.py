"""Extract student details without changing the source or guessing identities."""
import argparse,collections,datetime,hashlib,json,os,re,unicodedata
import openpyxl

def norm(value):
    value=unicodedata.normalize('NFKD',str(value or ''))
    return re.sub(r'[^A-Z0-9]+',' ',''.join(c for c in value if not unicodedata.combining(c)).upper()).strip()

def prepare(path):
    w=openpyxl.load_workbook(path,read_only=True,data_only=True);records=[];issues=[];conversions=[]
    for s in w:
        schoolclass=s.title.split()[0].upper()
        if schoolclass not in ['GARDE','PS','MS','GS','CI','CP','CE1','CE2','CM1','CM2']:continue
        rows=s.iter_rows(max_col=19,values_only=True);headers=next(rows);section=norm(headers[5]).replace(' ','')=='AB';shift=1 if section else 0
        fields={3:'birthPlace',5+shift:'orphanStatus',6+shift:'address',7+shift:'fatherName',8+shift:'fatherPhone',9+shift:'fatherEmail',10+shift:'motherName',11+shift:'motherPhone',12+shift:'motherEmail',13+shift:'familyStatus',14+shift:'emergencyContact',15+shift:'guardianName',16+shift:'guardianPhone',17+shift:'guardianEmail'}
        for rowno,r in enumerate(rows,2):
            if not r[0] or not r[1]:continue
            info={k:str(r[c]).strip() for c,k in fields.items() if r[c] is not None and str(r[c]).strip()}
            if section and r[5] is not None:info['section']=str(r[5]).strip()
            source=f'{s.title}!A{rowno}:S{rowno}';birth=r[2];gender=norm(r[4])
            if isinstance(birth,str):
                raw=birth;parts=re.fullmatch(r'(\d{1,2})[- /]+([A-Z]+)[- /]+(\d{2}|\d{4})',norm(birth).replace(' ','-'))
                months={'JAN':1,'JANV':1,'JANVIER':1,'FEB':2,'FEV':2,'FEVRIER':2,'MAR':3,'MARS':3,'APR':4,'AVR':4,'AVRIL':4,'MAY':5,'MAI':5,'JUN':6,'JUIN':6,'JUL':7,'JUIL':7,'JUILLET':7,'AUG':8,'AOUT':8,'SEP':9,'SEPT':9,'SEPTEMBRE':9,'OCT':10,'OCTOBRE':10,'NOV':11,'NOVEMBRE':11,'DEC':12,'DECEMBRE':12}
                if parts and parts[2] in months:
                    year=int(parts[3]);year=year+2000 if len(parts[3])==2 else year
                    try:
                        birth=datetime.date(year,months[parts[2]],int(parts[1]))
                        conversions.append(dict(source=source,before=raw,after=birth.isoformat()))
                    except ValueError:pass
            if isinstance(birth,(datetime.date,datetime.datetime)):
                birth=birth.date() if isinstance(birth,datetime.datetime) else birth
                if datetime.date(2000,1,1)<=birth<=datetime.date(2026,11,15):info['birth']=birth.isoformat()
                else:issues.append(dict(source=source,field='birth',value=str(birth),reason='Date hors plage, à vérifier'))
            elif birth is not None:issues.append(dict(source=source,field='birth',value=str(birth),reason='Date non reconnue'))
            if gender in ['FEMININ','F']:info['gender']='F'
            elif gender in ['MASCULIN','M']:info['gender']='M'
            elif gender:issues.append(dict(source=source,field='gender',value=str(r[4]),reason='Sexe non reconnu'))
            for field in ['fatherEmail','motherEmail','guardianEmail']:
                if field in info and not re.fullmatch(r'[^\s@]+@[^\s@]+\.[^\s@]+',info[field]):issues.append(dict(source=source,field=field,value=info[field],reason='Adresse e-mail à vérifier'))
            records.append(dict(firstName=str(r[1]).strip(),lastName=str(r[0]).strip(),schoolClass=schoolclass,source=source,fields=info))
    return dict(format=1,year='2026-2027',sourceHash=hashlib.sha256(open(path,'rb').read()).hexdigest(),records=records,issues=issues,dateConversions=conversions)
if __name__=='__main__':
    p=argparse.ArgumentParser();p.add_argument('workbook');p.add_argument('output');a=p.parse_args();d=prepare(a.workbook)
    with open(a.output,'w') as f:json.dump(d,f,ensure_ascii=False,indent=2)
    os.chmod(a.output,0o600)
    print(json.dumps({'records':len(d['records']),'classes':dict(collections.Counter(r['schoolClass'] for r in d['records'])),'sourceIssues':len(d['issues'])}))
