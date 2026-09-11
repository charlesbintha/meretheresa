(()=>{
'use strict';
const M=MT,A=M.actions;let busy=false;
const status=text=>{M.$('#save-status').textContent=text;};
function apply(state){if(!Array.isArray(state.students)||!Number.isInteger(state.revision))throw Error('Données serveur incomplètes.');M.db=state;M.ready=true;for(const k of ['gradeClass','scheduleClass'])if(!M.cls(M.view[k]))M.view[k]=state.classes[0]?.id||0;if(!M.subject(M.view.subject))M.view.subject=state.subjects[0]?.id||0;status('Synchronisé');}
async function request(path,body){
 let response;try{response=await fetch('/school-api/'+path,{credentials:'same-origin',headers:{Accept:'application/json','Content-Type':'application/json','X-CSRF-TOKEN':M.$('meta[name="csrf-token"]').content},...(body?{method:'POST',body:JSON.stringify(body)}:{})});}catch(_){throw Error('Serveur inaccessible. Vérifiez la connexion puis réessayez.');}
 if(response.status===401){location.assign('/login');throw Error('Votre session a expiré.');}
 const data=await response.json().catch(()=>{throw Error('Réponse du serveur illisible. Aucun enregistrement confirmé.');});
 if(!response.ok){const error=Error(response.status===419?'Session expirée : rechargez la page avant de réessayer.':response.status===409?'Un autre changement a été enregistré. Les données ont été actualisées ; vérifiez votre saisie puis réessayez.':response.status>=500?'Le serveur n’a pas confirmé l’enregistrement. Réessayez.':Object.values(data.errors||{}).flat().join(' ')||data.message||'Action refusée.');error.status=response.status;throw error;}
 return data;
}
M.command=async(action,payload={},id=null)=>{
 if(busy)throw Error('Un enregistrement est déjà en cours. Patientez un instant.');busy=true;status('Enregistrement…');
 try{const result=await request('commands',{action,payload,id:id==null?null:String(id),revision:M.db.revision});apply(result.state);if(result.csrfToken){M.$('meta[name="csrf-token"]').content=result.csrfToken;document.querySelectorAll('input[name="_token"]').forEach(input=>input.value=result.csrfToken);}return result;}
 catch(error){status('Non synchronisé');if(error.status===409){try{apply(await request('state'));}catch(_){}}throw error;}
 finally{busy=false;}
};
const run=async(action,payload={},id=null,close=false)=>{try{const result=await M.command(action,payload,id);if(close)M.close();M.render();M.notify('Enregistré dans la base de données.');return result;}catch(e){M.notify(e.message,true);return null;}};
// Preferences are the only optimistic writes; school records always await the server.
let preferenceQueue=Promise.resolve();
M.persist=()=>{const payload={theme:M.db.settings.theme,compact:!!M.db.settings.compact,widgets:[...M.db.widgets],notificationsRead:!!M.db.notificationsRead};preferenceQueue=preferenceQueue.then(async()=>{try{await M.command('preferences',payload);M.render();}catch(e){try{apply(await request('state'));M.render();}catch(_){}M.notify(e.message,true);}});return preferenceQueue;};
for(const [name,action] of Object.entries({'enrollment-approve':'enrollment-approve','reject-confirmed':'enrollment-reject','subscription-toggle':'subscription-toggle','lesson-delete':'lesson-delete','year-activate':'year-activate'}))A[name]=el=>run(action,{},el.dataset.id,['reject-confirmed','lesson-delete'].includes(name));
A['save-grades']=async()=>{
 const inputs=[...document.querySelectorAll('[data-grade]')];const invalid=inputs.find(i=>i.value===''||!i.checkValidity());if(invalid){invalid.focus();M.notify('Saisissez les notes entre 0 et 20 avant d’enregistrer.',true);return;}
 const rows=new Map();for(const input of inputs){const id=Number(input.dataset.student);if(!rows.has(id))rows.set(id,{studentId:id});rows.get(id)[input.dataset.grade]=Number(input.value);}
 await run('grades',{classId:M.view.gradeClass,subjectId:M.view.subject,term:Number(M.view.term),rows:[...rows.values()]});
};
A.reset=A['reset-confirm']=()=>M.notify('Le remplacement des données s’effectue uniquement depuis le serveur.',true);
M.totalDue=s=>M.db.tuitions.filter(t=>t.studentId===s.id).reduce((n,t)=>n+t.total,0);
M.paid=s=>M.db.tuitions.filter(t=>t.studentId===s.id).reduce((n,t)=>n+t.paid,0);
M.balance=s=>M.db.tuitions.filter(t=>t.studentId===s.id).reduce((n,t)=>n+t.balance,0);
M.grade=(sid,subject,kind,term=M.view.term)=>M.db.grades[`${sid}-${subject}-${term}-${kind}`]??'';
M.average=(sid,subject)=>{const a=M.grade(sid,subject,'test'),b=M.grade(sid,subject,'exam');return a===''||b===''?null:(a+b*2)/3;};
M.generalAverage=sid=>{const subjects=M.db.subjects;if(!subjects.length)return null;const scores=subjects.map(s=>M.average(sid,s.id));if(scores.some(s=>s===null))return null;return subjects.reduce((sum,s,i)=>sum+scores[i]*s.coefficient,0)/subjects.reduce((sum,s)=>sum+s.coefficient,0);};
M.score=value=>value===null?'—':Number(value).toFixed(2);
M.paymentDate=()=>{const y=M.db.years.find(y=>y.active),today=new Date().toISOString().slice(0,10);return y?today<y.start?y.start:today>y.end?y.end:today:today;};
M.chartYear=()=>M.db.years.find(y=>y.active)?.end.slice(0,4)||String(new Date().getFullYear());
M.chartValues=()=>{const month={janvier:'01',février:'02',mars:'03'}[M.view.period]||'03';return Array.from({length:7},(_,i)=>M.db.payments.filter(p=>p.date.startsWith(M.chartYear()+'-'+month)&&Math.min(6,Math.floor((Number(p.date.slice(-2))-1)/4))===i).reduce((sum,p)=>sum+p.amount,0));};
M.$('#main').innerHTML='<div class="empty-state"><h3>Chargement de l’établissement…</h3></div>';
request('state').then(state=>{apply(state);M.navigate(location.hash.slice(1)||'dashboard');}).catch(error=>{status('Connexion impossible');M.$('#main').innerHTML=`<div class="empty-state"><h3>Chargement impossible</h3><p>${M.esc(error.message)}</p><a class="btn primary" href="/">Réessayer</a></div>`;});
})();
