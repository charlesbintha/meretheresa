const {test}=require('node:test'),assert=require('node:assert/strict'),vm=require('node:vm'),fs=require('node:fs');
test('expense view, detail, payment and export use the same filtered data',async()=>{
 const handlers={},calls=[];let modal='';const data={expenses:[{id:1,supplier_id:1,supplier:'Papeterie <test>',year_id:1,entry_id:1,date:'2026-10-01',reference:'F1',memo:'Cahiers',account:'6051',amount:20000,status:'posted',paid:5000,pending:0,balance:15000,available:15000,payments:[]}],suppliers:[{id:1,name:'Papeterie <test>'}],documents:[],years:[{id:1,name:'2026',closed:false}],accounts:[{code:'6051',name:'Fournitures'}],treasury:[{id:1,name:'BOA'}]};
 const M={routePermission:{},views:{},actions:{},view:{route:'expenses'},esc:x=>String(x).replaceAll('<','&lt;').replaceAll('>','&gt;'),can:()=>true,money:String,button:(l,a,i,attr)=>`<button data-action="${a}" ${attr}>${l}</button>`,heading:(a,b,c)=>a+b+c,table:(h,r)=>r.join(''),field:(l,n,v)=>`<input name="${n}" value="${v}">`,selectField:(l,n,o)=>`<select name="${n}">${o}</select>`,formFooter:()=>'',render:()=>{},notify:(...a)=>calls.push(a),modal:(t,b)=>{modal=b;},exportTable:(...a)=>calls.push(a)};
 vm.runInNewContext(fs.readFileSync('public/template/expenses.js','utf8'),{MT:M,fetch:async()=>({ok:true,json:async()=>data}),document:{addEventListener:(n,h)=>handlers[n]=h},Date,console});
 M.views.expenses();await new Promise(r=>setImmediate(r));assert(M.views.expenses().includes('Papeterie &lt;test&gt;'));
 M.actions['exp-detail']({dataset:{id:'1'}});assert(modal.includes('Justificatif manquant'));assert(modal.includes('15000'));
 M.actions['exp-pay']({dataset:{id:'1'}});assert(modal.includes('BOA'));assert(modal.includes('value="15000"'));
 M.actions['exp-export']();assert.equal(calls.at(-1)[3],'accounting');assert.equal(calls.at(-1)[2][0][7],15000);
 handlers.change({target:{dataset:{expFilter:'q'},value:'inexistant'}});M.actions['exp-export']();assert.equal(calls.at(-1)[2].length,0);
});
