(()=>{
'use strict';
let sequence=0;
const normalize=s=>s.normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLocaleLowerCase('fr').replace(/[-\s]+/g,' ').trim();
function enhance(select){
 if(select.dataset.searchReady)return;select.dataset.searchReady='1';
 const options=[...select.options].map(o=>({value:o.value,label:o.textContent,disabled:o.disabled}));
 const wrapper=document.createElement('div');wrapper.className='student-search';select.after(wrapper);wrapper.append(select);
 const input=document.createElement('input'),list=document.createElement('div'),hint=document.createElement('div');
 const id='student-search-'+(++sequence);input.type='text';input.className='student-search-input';input.autocomplete='off';input.placeholder='Nom, prénom ou matricule…';input.setAttribute('role','combobox');input.setAttribute('aria-autocomplete','list');input.setAttribute('aria-expanded','false');input.setAttribute('aria-controls',id);input.setAttribute('aria-label','Rechercher et sélectionner un élève');input.disabled=select.disabled;
 list.id=id;list.className='student-search-results';list.setAttribute('role','listbox');list.setAttribute('aria-label','Élèves');list.hidden=true;hint.className='student-search-hint';hint.setAttribute('role','status');
 wrapper.append(input,list,hint);const required=select.required;select.required=false;select.hidden=true;input.required=required;
 let matches=[],index=-1;
 const label=()=>options.find(o=>o.value===select.value)?.label||'';
 const restore=()=>{input.value=label();input.setCustomValidity(required&&!select.value?'Sélectionnez un élève.':'');};restore();
 function close(){list.hidden=true;input.setAttribute('aria-expanded','false');input.removeAttribute('aria-activedescendant');hint.textContent='';index=-1;restore();}
 function active(){[...list.querySelectorAll('[role=option]')].forEach((b,i)=>{b.classList.toggle('focused',i===index);});if(index>=0){input.setAttribute('aria-activedescendant',id+'-'+index);list.children[index]?.scrollIntoView({block:'nearest'});}}
 function choose(option){if(option.disabled)return;select.value=option.value;input.focus({preventScroll:true});close();select.dispatchEvent(new Event('change',{bubbles:true}));}
 function open(query=''){
  const words=normalize(query).split(' ').filter(Boolean);matches=options.filter(o=>!o.disabled&&words.every(w=>normalize(o.label).includes(w)));index=-1;list.replaceChildren();
  matches.forEach((o,i)=>{const item=document.createElement('button');item.type='button';item.id=id+'-'+i;item.tabIndex=-1;item.setAttribute('role','option');item.setAttribute('aria-selected',String(o.value===select.value));item.textContent=o.label;item.addEventListener('mousedown',e=>e.preventDefault());item.addEventListener('click',e=>{e.preventDefault();choose(o);});list.append(item);});
  if(!matches.length){const empty=document.createElement('p');empty.textContent='Aucun élève trouvé';list.append(empty);}
  list.hidden=false;input.setAttribute('aria-expanded','true');input.removeAttribute('aria-activedescendant');hint.textContent=matches.length+' résultat'+(matches.length>1?'s':'');
 }
 input.addEventListener('focus',()=>{open();input.select();});input.addEventListener('click',()=>{if(list.hidden){open();input.select();}});
 input.addEventListener('input',()=>{input.setCustomValidity('Choisissez un élève dans la liste.');open(input.value);});
 input.addEventListener('keydown',e=>{if(e.key==='Escape'){e.preventDefault();close();}else if(e.key==='ArrowDown'||e.key==='ArrowUp'){e.preventDefault();if(list.hidden)open();index=Math.max(0,Math.min(matches.length-1,index+(e.key==='ArrowDown'?1:-1)));active();}else if(e.key==='Enter'&&!list.hidden){e.preventDefault();if(index>=0&&matches[index])choose(matches[index]);else if(matches.length===1)choose(matches[0]);}else if(e.key==='Tab')close();});
 wrapper.addEventListener('focusout',()=>setTimeout(()=>{if(!wrapper.contains(document.activeElement))close();},0));
 select.addEventListener('change',restore);select.form?.addEventListener('reset',()=>setTimeout(close,0));
}
const scan=()=>document.querySelectorAll('select[name="student"],select[name="studentId"]').forEach(enhance);
new MutationObserver(scan).observe(document.body,{childList:true,subtree:true});scan();
})();
