(()=>{
const M=MT;
M.accountingReport=(data,type,from,to,account='')=>{
 const year=data.years.find(y=>Number(y.id)===Number(data.yearId));from||=year.start;to||=year.end;
 const names=Object.fromEntries(data.accounts.map(a=>[a.code,a.name]));
 const entries=data.entries.filter(e=>e.status==='posted'&&e.date<=to).sort((a,b)=>a.date.localeCompare(b.date)||a.id-b.id);
 const totals={};const all=[];
 for(const e of entries)for(const l of e.lines){const c=l.account,t=totals[c]||={opening:0,debit:0,credit:0};if(e.date<from)t.opening+=Number(l.debit)-Number(l.credit);else{t.debit+=Number(l.debit);t.credit+=Number(l.credit);}all.push({...l,date:e.date,number:e.number,reference:e.reference,memo:e.memo});}
 const balance=Object.entries(totals).sort(([a],[b])=>a.localeCompare(b)).filter(([c])=>!account||c===account).map(([c,t])=>{const n=t.opening+t.debit-t.credit;return[c,names[c],Math.max(t.opening,0),Math.max(-t.opening,0),t.debit,t.credit,Math.max(n,0),Math.max(-n,0)];});
 if(type==='balance'){const sum=Array(6).fill(0);balance.forEach(r=>r.slice(2).forEach((v,i)=>sum[i]+=v));return{headers:['Compte','Libellé','Ouverture débit','Ouverture crédit','Mouvements débit','Mouvements crédit','Solde débit','Solde crédit'],rows:[...balance,['TOTAL','',...sum]]};}
 if(type==='ledger'){const rows=[];for(const [code] of Object.entries(totals).sort(([a],[b])=>a.localeCompare(b))){if(account&&code!==account)continue;let running=totals[code].opening;rows.push([code,names[code],from,'','Ouverture','','',0,0,running]);for(const l of all.filter(l=>l.account===code&&l.date>=from)){running+=Number(l.debit)-Number(l.credit);rows.push([code,names[code],l.date,l.number,l.label||l.memo,l.reference,l.auxiliary||'',Number(l.debit),Number(l.credit),running]);}}return{headers:['Compte','Libellé compte','Date','Écriture','Libellé','Référence','Tiers','Débit','Crédit','Solde signé'],rows};}
 // Financial statements use the entire fiscal year up to the selected closing date.
 const net={};for(const e of entries)for(const l of e.lines)net[l.account]=(net[l.account]||0)+Number(l.debit)-Number(l.credit);
 const sum=(prefixes,sign=1)=>Object.entries(net).filter(([c])=>prefixes.some(p=>c.startsWith(p))).reduce((s,[,n])=>s+n*sign,0);
 const specs=[['TA','Ventes de marchandises',['701'],-1],['RA','Achats de marchandises',['601'],1],['RB','Variation de stocks de marchandises',['6031'],1],['TB','Ventes de produits fabriqués',['702','703','704'],-1],['TC','Travaux et services vendus',['705','706'],-1],['TD','Produits accessoires',['707'],-1],['TE','Production stockée',['73'],-1],['TF','Production immobilisée',['72'],-1],['TG','Subventions d’exploitation',['71'],-1],['TH','Autres produits',['75'],-1],['TI','Transferts de charges d’exploitation',['781'],-1],['RC','Achats de matières premières',['602'],1],['RD','Variation de stocks de matières premières',['6032'],1],['RE','Autres achats',['604','605','608'],1],['RF','Variation des autres stocks',['6033'],1],['RG','Transports',['61'],1],['RH','Services extérieurs',['62','63'],1],['RI','Impôts et taxes',['64'],1],['RJ','Autres charges',['65'],1],['RK','Charges de personnel',['66'],1],['TJ','Reprises d’amortissements et provisions',['791','798','799'],-1],['RL','Dotations aux amortissements et provisions',['681','691'],1],['TK','Revenus financiers',['77'],-1],['TL','Reprises de provisions financières',['797'],-1],['TM','Transferts de charges financières',['787'],-1],['RM','Frais financiers',['67'],1],['RN','Dotations aux provisions financières',['697'],1],['TN','Produits des cessions d’immobilisations',['82'],-1],['TO','Autres produits HAO',['84','86','88'],-1],['RO','Valeur comptable des cessions',['81'],1],['RP','Autres charges HAO',['83','85'],1],['RQ','Participation des travailleurs',['87'],1],['RS','Impôts sur le résultat',['89'],1]];
 const profit=Object.entries(net).filter(([c])=>/^[678]/.test(c)).reduce((n,[,v])=>n-v,0);
 if(type==='income'){
  const rows=specs.map(([ref,label,p,sign])=>[ref,label,sum(p,sign)]);const matched=c=>specs.some(s=>s[2].some(p=>c.startsWith(p)));
  for(const [c,n] of Object.entries(net))if(/^[678]/.test(c)&&!matched(c))rows.push([c,'Autre compte de résultat à vérifier : '+names[c],-n]);
  const at=ref=>rows.find(r=>r[0]===ref)?.[2]||0;const turnover=at('TA')+at('TB')+at('TC')+at('TD');
  const valueAdded=turnover-at('RA')-at('RB')+['TE','TF','TG','TH','TI'].reduce((s,r)=>s+at(r),0)-['RC','RD','RE','RF','RG','RH','RI','RJ'].reduce((s,r)=>s+at(r),0);
  const operating=sum(['70','71','72','73','75','781','791','798','799'],-1)-sum(['60','61','62','63','64','65','66','681','691']);
  const financial=at('TK')+at('TL')+at('TM')-at('RM')-at('RN');
  rows.push(['XA','MARGE COMMERCIALE',at('TA')-at('RA')-at('RB')],['XB','CHIFFRE D’AFFAIRES',turnover],['XC','VALEUR AJOUTÉE',valueAdded],['XD','EXCÉDENT BRUT D’EXPLOITATION',valueAdded-at('RK')],['XE','RÉSULTAT D’EXPLOITATION',operating],['XF','RÉSULTAT FINANCIER',financial],['XG','RÉSULTAT DES ACTIVITÉS ORDINAIRES',operating+financial],['XH','RÉSULTAT HORS ACTIVITÉS ORDINAIRES',at('TN')+at('TO')-at('RO')-at('RP')],['XI','RÉSULTAT NET',profit]);return{headers:['Référence','Rubrique','Montant FCFA'],rows};
 }
 // Net presentation, with debit/credit reclassification for third-party and bank balances.
 const asset={},liability={};const add=(o,k,n)=>o[k]=(o[k]||0)+n;
 for(const [c,n] of Object.entries(net)){if(/^[6789]/.test(c))continue;
  if(c.startsWith('109'))add(liability,'Capital non appelé (déduction)',-n);
  else if(c[0]==='1')add(liability,/^(10|11|12|13)/.test(c)?'Capitaux propres et résultat antérieur':c.startsWith('14')||c.startsWith('15')?'Subventions et provisions réglementées':'Dettes financières et provisions',-n);
  else if(c[0]==='2')add(asset,'Immobilisations nettes (amortissements et dépréciations déduits)',n);
  else if(c[0]==='3')add(asset,'Stocks nets',n);
  else if(c.startsWith('49')){if(c.startsWith('499'))add(liability,'Provisions pour risques à court terme',-n);else add(asset,'Dépréciations des créances (déduction)',n);}
  else if(c.startsWith('59')){if(c.startsWith('599'))add(liability,'Provisions de trésorerie',-n);else add(asset,'Dépréciations de trésorerie (déduction)',n);}
  else if(c.startsWith('478'))add(asset,'Écarts de conversion actif',n);
  else if(c.startsWith('479'))add(liability,'Écarts de conversion passif',-n);
  else if(c[0]==='4'){if(n>=0)add(asset,c.startsWith('41')?'Créances familles et clients':'Autres créances',n);else add(liability,c.startsWith('40')?'Dettes fournisseurs':c.startsWith('42')||c.startsWith('43')||c.startsWith('44')?'Dettes sociales et fiscales':'Autres dettes et avances reçues',-n);}
  else if(c[0]==='5'){if(n>=0)add(asset,'Trésorerie actif',n);else add(liability,'Trésorerie passif',-n);}
 }
 add(liability,'Résultat net de l’exercice',profit);const a=Object.values(asset).reduce((a,b)=>a+b,0),p=Object.values(liability).reduce((a,b)=>a+b,0);
 return{headers:['Section','Rubrique','Montant FCFA'],rows:[...Object.entries(asset).map(([k,v])=>['ACTIF',k,v]),['ACTIF','TOTAL ACTIF',a],...Object.entries(liability).map(([k,v])=>['PASSIF',k,v]),['PASSIF','TOTAL PASSIF',p],['CONTRÔLE','Écart actif − passif',a-p]]};
};
})();
