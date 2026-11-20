(()=>{
'use strict';
const M=MT,E=M.esc,B=M.button,labels={tuition:'Scolarité',studies:'Études',canteen:'Cantine',transport:'Transport'};
let filters={month:'',classId:'',query:'',status:'due'};
M.routePermission['monthly-invoices']='finance.view';
// Use recorded charges rather than generating fees from today's subscriptions.
M.monthlyInvoiceData=(month,classId='',query='',status='due')=>{
 if(!M.can('finance.view'))return [];
 const paid=new Map(),groups=new Map();
 for(const r of M.db.billing?.receipts||[])paid.set(r.charge_id,(paid.get(r.charge_id)||0)+Number(r.amount));
 const students=new Map(M.db.students.map(s=>[s.id,s]));
 for(const c of M.db.billing?.charges||[]){
  if(c.month!==month||!labels[c.kind])continue;
  const s=students.get(c.student_id);if(!s||(classId&&String(s.classId)!==classId)||!(M.name(s)+' '+s.matricule).toLocaleLowerCase('fr').includes(query.toLocaleLowerCase('fr').trim()))continue;
  if(!groups.has(s.id))groups.set(s.id,{student:s,lines:[],total:0,paid:0,balance:0,pending:false});
  const invoice=groups.get(s.id),net=Number(c.amount)-Number(c.waiver),received=paid.get(c.id)||0;
  let line=invoice.lines.find(l=>l.kind===c.kind);if(!line){line={kind:c.kind,amount:0,waiver:0,paid:0,balance:0};invoice.lines.push(line);}
  line.amount+=Number(c.amount);line.waiver+=Number(c.waiver);line.paid+=received;line.balance+=Math.max(0,net-received);
  invoice.total+=net;invoice.paid+=received;invoice.balance+=Math.max(0,net-received);invoice.pending||=!!c.tariff_pending;
 }
 return [...groups.values()].filter(i=>status!=='due'||i.balance>0||i.pending).sort((a,b)=>M.name(a.student).localeCompare(M.name(b.student),'fr'));
};
function monthLabel(month){return new Intl.DateTimeFormat('fr',{month:'long',year:'numeric',timeZone:'UTC'}).format(new Date(month+'-01T00:00:00Z'));}
function current(){const months=[...new Set((M.db.billing?.charges||[]).filter(c=>labels[c.kind]).map(c=>c.month))].sort();if(!months.includes(filters.month)){const now=new Date().toLocaleDateString('sv-SE').slice(0,7);filters.month=months.includes(now)?now:months[0]||'';}return months;}
M.monthlyInvoiceHTML=(invoice,month)=>{
 const s=invoice.student,settings=M.db.settings;
 return `<article class="monthly-invoice"><header><div class="invoice-school"><img src="/template/assets/school-logo.jpg" alt="Logo de Mère Thérèsa"><div><strong>${E(settings.school||'Mère Thérèsa')}</strong><div>Groupe scolaire · ${E(settings.city||'')}</div><small>${E(settings.address||'')} · ${E(settings.phone||'')}</small></div></div><div><h2>Facture mensuelle</h2><b>${E(monthLabel(month))}</b><small>FAC-${E(month.replace('-',''))}-${E(s.matricule)}</small></div></header><div class="invoice-family"><div><b>${E(M.name(s))}</b><br>${E(s.matricule)} · Classe : ${E(M.cls(s.classId)?.name||'—')}</div><div>Responsable : ${E(s.parent||'À compléter')}<br>Contact : ${E(s.phone||'À compléter')}<br>Année scolaire : ${E(M.db.years.find(y=>y.active)?.name||'')}</div></div>${invoice.pending?'<p class="invoice-warning">Tarif à compléter — document non prêt à envoyer.</p>':''}<table><thead><tr><th>Désignation</th><th>Tarif</th><th>Remise</th><th>Déjà payé</th><th>À payer</th></tr></thead><tbody>${invoice.lines.sort((a,b)=>Object.keys(labels).indexOf(a.kind)-Object.keys(labels).indexOf(b.kind)).map(l=>`<tr><td>${E(labels[l.kind])}</td><td>${M.money(l.amount)}</td><td>${M.money(l.waiver)}</td><td>${M.money(l.paid)}</td><td>${M.money(l.balance)}</td></tr>`).join('')}</tbody></table><div class="invoice-total"><span>Total restant à payer · FCFA</span><strong>${M.money(invoice.balance)}</strong></div><footer>Situation au ${E(M.date(new Date().toLocaleDateString('sv-SE')))} · Montants en FCFA.<br>Cette facture concerne uniquement ${E(monthLabel(month))}. Les autres mois et les frais d’inscription ne sont pas inclus.<br>Merci de rappeler le matricule de l’élève lors du règlement. Ce document ne vaut pas reçu de paiement.</footer></article>`;
};
M.monthlyInvoiceSheets=(invoices,month)=>{let html='';for(let i=0;i<invoices.length;i+=2)html+=`<section class="invoice-paper">${invoices.slice(i,i+2).map(r=>M.monthlyInvoiceHTML(r,month)).join('')}</section>`;return html;};
M.views['monthly-invoices']=()=>{
 if(!M.can('finance.view'))return '';
 const months=current(),rows=M.monthlyInvoiceData(filters.month,filters.classId,filters.query,filters.status),pending=rows.filter(r=>r.pending).length;
 return M.heading('Préparer les factures','Une facture par élève regroupant les frais du mois.',B('Retour aux factures','navigate','arrow-left','data-route="billing"','')+B('Imprimer / PDF','monthly-invoices-print','printer',rows.length?'':'disabled'))+`<form id="monthly-invoice-filters" class="card invoice-filters"><label>Mois<select name="month" required>${months.map(m=>`<option value="${E(m)}" ${m===filters.month?'selected':''}>${E(monthLabel(m))}</option>`).join('')}</select></label><label>Classe<select name="classId"><option value="">Toutes les classes</option>${M.db.classes.map(c=>`<option value="${c.id}" ${String(c.id)===filters.classId?'selected':''}>${E(c.name)}</option>`).join('')}</select></label><label>Élève<input name="query" type="search" placeholder="Nom ou matricule" value="${E(filters.query)}"></label><label>Afficher<select name="status"><option value="due" ${filters.status==='due'?'selected':''}>Restant à payer</option><option value="all" ${filters.status==='all'?'selected':''}>Toutes les factures</option></select></label><button class="btn primary" type="submit">Préparer</button></form><p class="subtitle invoice-count">${rows.length} factures · ${M.money(rows.reduce((n,r)=>n+r.balance,0))} FCFA à régler · A5 paysage, 2 par feuille A4.${pending?` ${pending} tarifs à compléter : ces factures seront exclues de l’impression.`:''}</p><p class="subtitle">Impression : papier A4 portrait, échelle 100 %, sans en-têtes ni pieds de page du navigateur. Choisissez « Enregistrer au format PDF » pour obtenir le fichier à transmettre.</p><div class="invoice-preview">${rows.length?M.monthlyInvoiceSheets(rows,filters.month):M.empty('Aucune facture','Aucune échéance ne correspond à ces filtres.')}</div>`;
};
document.addEventListener('submit',e=>{if(e.target.id!=='monthly-invoice-filters')return;e.preventDefault();filters=Object.fromEntries(new FormData(e.target));M.render();});
M.actions['monthly-invoices-print']=async()=>{
 if(!M.can('finance.view'))return;current();const rows=M.monthlyInvoiceData(filters.month,filters.classId,filters.query,filters.status).filter(r=>!r.pending);if(!rows.length)return M.notify('Aucune facture prête à imprimer.',true);
 const logo=new Image();logo.src='/template/assets/school-logo.jpg';try{await logo.decode();}catch(_){return M.notify('Le logo ne peut pas être chargé. Réessayez avant d’imprimer.',true);}
 document.body.classList.add('printing-monthly-invoices');try{M.print(M.monthlyInvoiceSheets(rows,filters.month));}finally{document.body.classList.remove('printing-monthly-invoices');}
};
const billing=M.views.billing;M.views.billing=()=>billing().replace('<div class="heading-actions">','<div class="heading-actions">'+B('Préparer les factures','navigate','file-text','data-route="monthly-invoices"'));
// Individual invoice links open the same monthly report, filtered to the pupil.
M.actions.invoice=el=>{if(!M.can('finance.view'))return;const s=M.student(el.dataset.id);if(!s)return;filters.query=s.matricule;filters.classId='';filters.status='all';M.navigate('monthly-invoices');};
})();
