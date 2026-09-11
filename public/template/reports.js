(()=>{
'use strict';
const M=MT,E=M.esc,B=M.button;
const types={students:['Effectifs','students.view'],payments:['Encaissements','finance.view'],balances:['Soldes de scolarité','finance.view'],grades:['Résultats scolaires','grades.view']};
const defaults=()=>({type:'students',classId:'',status:'',query:'',from:'',to:'',method:'',term:'2',result:''});
let filters=defaults(),applied=defaults();
let analyticsClass='';
const allowed=()=>Object.keys(types).filter(t=>M.can(types[t][1]));
const safeType=f=>{if(!allowed().includes(f.type))f.type=allowed()[0]||'';return f;};
const select=(name,label,options,value)=>M.selectField(label,name,options.map(([id,text])=>`<option value="${E(id)}" ${String(id)===String(value)?'selected':''}>${E(text)}</option>`).join(''));
const classes=()=>[['','Toutes les classes'],...M.db.classes.map(c=>[c.id,c.name])];
const year=()=>M.db.years.find(y=>y.active)?.name||'Année active';
const sum=(rows,key)=>rows.reduce((n,r)=>n+Number(r[key]||0),0);
const average=(id,term)=>{
 const subjects=M.db.subjects;if(!subjects.length)return null;
 let total=0,weight=0;
 for(const s of subjects){const a=M.db.grades[`${id}-${s.id}-${term}-test`],b=M.db.grades[`${id}-${s.id}-${term}-exam`];if(a==null||b==null)return null;total+=(Number(a)+2*Number(b))/3*s.coefficient;weight+=s.coefficient;}
 return weight?total/weight:null;
};
const students=f=>M.db.students.filter(s=>(!f.classId||s.classId===Number(f.classId))&&(!f.status||s.status===f.status)&&(!f.query||`${M.name(s)} ${s.matricule}`.toLocaleLowerCase('fr').includes(f.query.toLocaleLowerCase('fr'))));
function dataset(f){
 if(!allowed().includes(f.type))return {headers:[],rows:[],summary:''};
 const selected=students(f),ids=new Set(selected.map(s=>s.id));
 if(f.type==='payments'){
  const rows=M.db.payments.filter(p=>ids.has(p.studentId)&&(!f.from||p.date>=f.from)&&(!f.to||p.date<=f.to)&&(!f.method||p.method===f.method)).sort((a,b)=>b.date.localeCompare(a.date)||b.id-a.id);
  return {headers:['Référence','Élève','Classe','Date','Nature','Mode','Montant FCFA'],rows:rows.map(p=>[p.reference,M.name(M.student(p.studentId)),M.cls(M.student(p.studentId)?.classId)?.name,p.date,p.type,p.method,p.amount]),summary:`${rows.length} paiement(s) · ${M.money(sum(rows,'amount'))} FCFA encaissés`};
 }
 if(f.type==='balances'){
  const rows=selected.map(s=>({s,due:M.totalDue(s),paid:M.paid(s),balance:M.balance(s)})).filter(r=>!f.result||(f.result==='due'?r.balance>0:r.balance<=0));
  return {headers:['Matricule','Élève','Classe','Scolarité FCFA','Versé FCFA','Solde FCFA'],rows:rows.map(r=>[r.s.matricule,M.name(r.s),M.cls(r.s.classId)?.name,r.due,r.paid,r.balance]),summary:`${rows.length} élève(s) · ${M.money(sum(rows,'balance'))} FCFA de solde · Situation de l’année entière`};
 }
 if(f.type==='grades'){
  const rows=selected.map(s=>({s,score:average(s.id,f.term)})).filter(r=>!f.result||(f.result==='missing'?r.score===null:r.score!==null&&(f.result==='passed'?r.score>=10:r.score<10)));
  return {headers:['Matricule','Élève','Classe','Trimestre','Moyenne / 20','Résultat'],rows:rows.map(r=>[r.s.matricule,M.name(r.s),M.cls(r.s.classId)?.name,f.term,r.score===null?'':r.score.toFixed(2),r.score===null?'Notes incomplètes':r.score>=10?'Moyenne atteinte':'Sous la moyenne']),summary:`${rows.length} élève(s) · Trimestre ${f.term} · Moyenne pondérée : devoir × 1, composition × 2, puis coefficients des matières`};
 }
 return {headers:['Matricule','Élève','Classe','Statut','Date d’inscription'],rows:selected.map(s=>[s.matricule,M.name(s),M.cls(s.classId)?.name,s.status,s.joined]),summary:`${selected.length} élève(s) · ${selected.filter(s=>s.status==='Actif').length} actif(s)`};
}
// Reused by the screen, print view and CSV so they always share the same filters.
M.reporting={dataset,average};
function tabs(active){return `<div class="report-tabs"><a href="#analytics" class="${active==='analytics'?'active':''}">${M.icon('chart-pie')}KPI & diagrammes</a><a href="#reports" class="${active==='reports'?'active':''}">${M.icon('report-analytics')}Rapports filtrables</a></div>`;}
const noAccess=()=>M.empty('Aucun rapport accessible','Votre rôle ne dispose pas de droits sur les données scolaires ou financières.');
function filterForm(){
 const f=safeType(filters);
 return `<form id="report-filters" class="card report-filters"><div class="report-filter-grid">${select('type','Type de rapport',allowed().map(t=>[t,types[t][0]]),f.type)}${select('classId','Classe',classes(),f.classId)}${M.field('Élève ou matricule','query',f.query,'search','maxlength="100"')}${select('status','Statut de l’élève',[['','Tous les statuts'],['Actif','Actif'],['En attente','En attente'],['Archivé','Archivé']],f.status)}${f.type==='payments'?`${M.field('Paiements depuis le','from',f.from,'date')}${M.field('Paiements jusqu’au','to',f.to,'date')}${select('method','Mode de paiement',[['','Tous les modes'],...[...new Set(M.db.payments.map(p=>p.method))].sort().map(m=>[m,m])],f.method)}`:''}${f.type==='grades'?select('term','Trimestre',[['1','1er trimestre'],['2','2e trimestre'],['3','3e trimestre']],f.term):''}${['grades','balances'].includes(f.type)?select('result','Résultat',[['','Tous'],...(f.type==='grades'?[['passed','Moyenne ≥ 10'],['failed','Moyenne < 10'],['missing','Notes incomplètes']]:[['due','Solde à régler'],['paid','Solde nul ou créditeur']])],f.result):''}</div><div class="report-filter-actions"><span class="subtitle">Année scolaire : ${E(year())}</span>${B('Réinitialiser','reports-reset','x','','')}<button type="submit" class="btn primary">${M.icon('filter')}Appliquer les filtres</button></div><p class="report-filter-error" role="alert" hidden></p></form>`;
}
M.views.reports=()=>{
 safeType(applied);const d=dataset(applied),pg=M.paginate(d.rows,15);
 return M.heading('Rapports filtrables','Consultez, exportez et imprimez les données de l’année active.',allowed().length?B('Exporter CSV','reports-export','download','','')+B('Imprimer','reports-print','printer','',''): '')+tabs('reports')+(!allowed().length?noAccess():filterForm()+`<section class="card report-results"><div class="report-results-head"><h2>${E(types[applied.type][0])}</h2><p class="subtitle">${E(d.summary)}</p><small>Les exports et l’impression comprennent tous les résultats des filtres appliqués.</small></div>${M.table(d.headers,pg.rows.map(row=>`<tr>${row.map(v=>`<td>${E(v===''?'—':v)}</td>`).join('')}</tr>`),pg.footer)}</section>`);
};
M.actions['reports-reset']=()=>{filters=defaults();applied=safeType(defaults());M.view.page=1;M.render();};
M.actions['reports-export']=()=>{const d=dataset(applied);if(!d.headers.length)return;M.csv(`mere-theresa-${applied.type}-${year()}`,d.headers,d.rows);};
M.actions['reports-print']=()=>{const d=dataset(applied);if(!d.headers.length)return;const details=[year(),applied.classId?M.cls(Number(applied.classId))?.name:'Toutes les classes',applied.status,applied.query,applied.type==='payments'?[applied.from&&`Depuis ${applied.from}`,applied.to&&`Jusqu’au ${applied.to}`,applied.method].filter(Boolean).join(' · '):'',applied.result].filter(Boolean).join(' · ');M.print(`<article class="report-sheet">${M.reportBrand()}<h2>${E(types[applied.type][0])}</h2><p>${E(details)}</p><p>${E(d.summary)}</p>${M.table(d.headers,d.rows.map(row=>`<tr>${row.map(v=>`<td>${E(v===''?'—':v)}</td>`).join('')}</tr>`))}</article>`);};
document.addEventListener('change',e=>{if(!e.target.closest('#report-filters'))return;Object.assign(filters,Object.fromEntries(new FormData(e.target.form)));if(e.target.name==='type'){filters.result='';M.render();}});
document.addEventListener('submit',e=>{
 if(e.target.id!=='report-filters')return;e.preventDefault();Object.assign(filters,Object.fromEntries(new FormData(e.target)));
 if(filters.type==='payments'&&filters.from&&filters.to&&filters.from>filters.to){const error=e.target.querySelector('.report-filter-error');error.textContent='La date de fin doit être postérieure ou égale à la date de début.';error.hidden=false;return;}
 applied={...filters};M.view.page=1;M.render();
});
const barChart=(title,subtitle,rows,unit='',action='')=>{
 const max=Math.max(1,...rows.map(r=>r.value));
 return `<section class="card report-chart"><h2>${E(title)}</h2><p class="subtitle">${E(subtitle)}</p>${!rows.length?M.empty('Aucune donnée','Aucun enregistrement pour cette sélection.'):`<div class="report-bars">${rows.map(r=>`<${action?'button':'div'} class="report-bar" ${action?`type="button" data-action="${action}" data-id="${E(r.id)}"`:''} title="${E(r.label)} : ${M.money(r.value)} ${E(unit)}"><span>${E(r.label)}</span><span class="report-bar-track"><span style="width:${r.value/max*100}%"></span></span><b>${M.money(r.value)}${unit?' '+E(unit):''}</b></${action?'button':'div'}>`).join('')}</div>`}</section>`;
};
M.views.analytics=()=>{
 const f={...defaults(),classId:analyticsClass},ss=students(f),ids=new Set(ss.map(s=>s.id)),payments=M.db.payments.filter(p=>ids.has(p.studentId));let stats=[],charts=[];
 if(M.can('students.view')){
  stats.push(M.miniStat('Élèves inscrits',ss.length,'users'),M.miniStat('Élèves actifs',ss.filter(s=>s.status==='Actif').length,'user-check'));
  charts.push(barChart('Effectifs par classe','Cliquez sur une classe pour consulter la liste des élèves.',M.db.classes.filter(c=>!analyticsClass||c.id===Number(analyticsClass)).map(c=>({id:c.id,label:c.name,value:ss.filter(s=>s.classId===c.id).length})),'','analytics-class-report'));
  const statuses=['Actif','En attente','Archivé'];charts.push(barChart('Statut des élèves','Répartition des inscriptions de la sélection.',statuses.map(label=>({label,value:ss.filter(s=>s.status===label).length}))));
 }
 if(M.can('finance.view')){
  stats.push(M.miniStat('Encaissements · FCFA',M.money(sum(payments,'amount')),'wallet'),M.miniStat('Solde de scolarité · FCFA',M.money(ss.reduce((n,s)=>n+M.balance(s),0)),'receipt'));
  const monthly=new Map();payments.forEach(p=>{const k=p.date.slice(0,7);monthly.set(k,(monthly.get(k)||0)+p.amount);});
  charts.push(barChart('Encaissements par mois','Tous les paiements de l’année active, selon la classe choisie.',[...monthly.entries()].sort(([a],[b])=>a.localeCompare(b)).map(([month,value])=>({label:new Date(month+'-01T12:00:00').toLocaleDateString('fr-FR',{month:'short',year:'numeric'}),value})),'FCFA'));
  charts.push(barChart('Modes de paiement','Montants encaissés, regroupés par mode.',[...new Set(payments.map(p=>p.method))].map(label=>({label,value:sum(payments.filter(p=>p.method===label),'amount')})),'FCFA'));
 }
 if(M.can('grades.view')){
  const scores=ss.filter(s=>s.status==='Actif').map(s=>average(s.id,'2')),complete=scores.filter(n=>n!==null),passed=complete.filter(n=>n>=10).length;
  stats.push(M.miniStat('Moyenne ≥ 10 · trimestre 2',complete.length?`${Math.round(passed/complete.length*100)} %`:'—','report-analytics'));
  charts.push(barChart('Résultats · 2e trimestre',`${complete.length} dossier(s) complet(s) sur ${scores.length} élèves actifs. Les notes manquantes ne valent pas zéro.`,[{label:'Moyenne ≥ 10',value:passed},{label:'Moyenne < 10',value:complete.length-passed},{label:'Notes incomplètes',value:scores.length-complete.length}]));
 }
 return M.heading('KPI & diagrammes','Les indicateurs de votre établissement, calculés à partir des données enregistrées.',B('Voir les rapports','navigate','report-analytics','data-route="reports"',''))+tabs('analytics')+`<div class="card analytics-controls"><span>Année scolaire <strong>${E(year())}</strong></span>${select('analyticsClass','Classe',classes(),analyticsClass)}</div>`+(stats.length?`<div class="report-kpis">${stats.join('')}</div><div class="report-chart-grid">${charts.join('')}</div>`:noAccess());
};
M.actions['analytics-class-report']=el=>{filters={...defaults(),classId:el.dataset.id};applied={...filters};M.navigate('reports');};
document.addEventListener('change',e=>{if(e.target.name==='analyticsClass'){analyticsClass=e.target.value;M.render();}});
})();
