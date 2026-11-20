(()=>{
const M=MT,E=M.esc;let pending=null;
M.exportTable=(name,headers,rows,scope)=>{
 const route=M.view.route;scope||=route.startsWith('accounting')?'accounting':['students','enrollments'].includes(route)||route.startsWith('students/')?'students':route==='grades'?'grades':route==='services'||route==='staff'?'services':'finance';
 if(!M.can(scope+'.view'))return M.notify('Vous ne pouvez pas exporter ces données.',true);
 pending={name,headers,rows,scope};M.modal('Exporter les données',`<p>${rows.length} lignes · Tous les résultats des filtres appliqués.</p><div class="form-footer"><button class="btn primary" data-action="download-export" data-format="xlsx">Télécharger Excel (.xlsx)</button><button class="btn" data-action="download-export" data-format="pdf">Télécharger PDF</button></div>`);
};
M.actions['download-export']=async el=>{if(!pending)return;const data={...pending,format:el.dataset.format};el.disabled=true;try{const r=await fetch('school-api/export',{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':M.$('meta[name="csrf-token"]').content},body:JSON.stringify(data)});if(!r.ok){const error=await r.json().catch(()=>({}));throw Error(error.message||'Export indisponible.');}const blob=await r.blob(),url=URL.createObjectURL(blob),a=document.createElement('a');a.href=url;a.download=data.name+'.'+data.format;a.click();setTimeout(()=>URL.revokeObjectURL(url),30000);M.close();M.notify('Le fichier '+data.format.toUpperCase()+' a été téléchargé.');}catch(error){M.notify(error.message,true);}finally{el.disabled=false;}};
})();
