(()=>{
'use strict';
const M=MT,states=new Map(),collator=new Intl.Collator('fr',{numeric:true,sensitivity:'base'});
const text=html=>{const el=document.createElement('template');el.innerHTML=html;el.content.querySelectorAll('svg,.avatar').forEach(n=>n.remove());return el.content.textContent.trim().replace(/\s+/g,' ');};
const months={'janv':1,'févr':2,'mars':3,'avr':4,'mai':5,'juin':6,'juil':7,'août':8,'sept':9,'oct':10,'nov':11,'déc':12};
function value(s){s=s.trim();if(!s||/^(?:[—–-]$|date à compléter|invalid date)/i.test(s))return null;
 let m=s.match(/^(\d{4})-(\d{2})-(\d{2})/);if(m)return Number(m[1]+m[2]+m[3]);
 m=s.match(/^(\d{1,2})[\/.-](\d{1,2})[\/.-](\d{4})$/);if(m)return Number(m[3]+m[2].padStart(2,'0')+m[1].padStart(2,'0'));
 m=s.match(/^(\d{1,2})\s+([a-zéû]+)\.?\s+(\d{4})/i);if(m&&months[m[2].toLowerCase()])return Number(m[3]+String(months[m[2].toLowerCase()]).padStart(2,'0')+m[1].padStart(2,'0'));
 const n=s.replace(/[\s\u00a0\u202f]/g,'').replace(/(?:FCFA|F|%)$/i,'').replace(',','.');return /^-?\d+(\.\d+)?$/.test(n)?Number(n):s;
}
function compare(a,b,direction){a=value(a);b=value(b);if(a===null||b===null)return a===b?0:a===null?1:-1;return (typeof a==='number'&&typeof b==='number'?a-b:collator.compare(String(a),String(b)))*direction;}
M.compareListValues=compare;
const paginate=M.paginate;M.paginate=(rows,size=8)=>{const pg=paginate(rows,size);return {...pg,allRows:rows,footer:pg.footer+`<!--list-page:${M.view.page}:${size}-->`};};
const table=M.table;
M.table=(headers,rows,footer='',empty='',pagination=null)=>{
 const match=footer.match(/<!--list-page:(\d+):(\d+)-->/);pagination||=match?{page:Number(match[1]),size:Number(match[2])}:null;
 const labels=headers.map(text),key=M.view.route+'|'+labels.join('|');
 const sortable=!['accounting-bilan','accounting-income','accounting-ledger','grades'].includes(M.view.route);
 const state=sortable?states.get(key):null;
 let ordered=rows;
 if(state){const parsed=document.createElement('tbody');ordered=rows.map((html,index)=>{parsed.innerHTML=html;const cell=parsed.firstElementChild?.children[state.column];const preferred=cell?.querySelector('.person-cell b')||cell?.querySelector('b');const sortValue=cell?.dataset.sortValue??(preferred?preferred.textContent:text(cell?.innerHTML||''));const pinned=/^(TOTAL|SOUS-TOTAL)\b/i.test(text(parsed.firstElementChild?.innerHTML||''));return{html,index,sortValue,pinned};}).sort((a,b)=>a.pinned!==b.pinned?(a.pinned?1:-1):a.pinned?a.index-b.index:compare(a.sortValue,b.sortValue,state.direction)||a.index-b.index).map(r=>r.html);}
 if(pagination)ordered=ordered.slice((pagination.page-1)*pagination.size,pagination.page*pagination.size);
 const decorated=headers.map((header,i)=>{
  if(!sortable||!labels[i]||/<input|<select/i.test(header)||/^(actions?|décision|reçu|facture)$/i.test(labels[i]))return header;
  const active=state?.column===i;return `<button type="button" class="list-sort" data-action="list-sort" data-key="${M.esc(key)}" data-column="${i}" aria-label="Trier par ${M.esc(labels[i])}, ${active&&state.direction===1?'ordre décroissant':'ordre croissant'}">${M.esc(labels[i])}<span aria-hidden="true">${active?(state.direction===1?'↑':'↓'):'↕'}</span></button>`;
 });
 let html=table(decorated,ordered,footer,empty);
 if(sortable){let i=0;html=html.replace(/<th scope="col">/g,()=>`<th scope="col" aria-sort="${state?.column===i++?(state.direction===1?'ascending':'descending'):'none'}">`);}
 if(headers.some(h=>h.includes('data-change="select-all"'))){const box=document.createElement('template');box.innerHTML=html;const all=box.content.querySelector('[data-change=select-all]'),visible=[...box.content.querySelectorAll('tbody [data-change=select-student]')];all?.toggleAttribute('checked',visible.length>0&&visible.every(x=>x.hasAttribute('checked')));html=box.innerHTML;}
 return html;
};
M.actions['list-sort']=el=>{const key=el.dataset.key,column=Number(el.dataset.column),previous=states.get(key);states.set(key,{column,direction:previous?.column===column?-previous.direction:1});M.view.page=1;M.resetAccountingPage?.();M.render();const button=[...document.querySelectorAll('[data-action=list-sort]')].find(b=>b.dataset.key===key&&Number(b.dataset.column)===column);button?.focus({preventScroll:true});};
})();
