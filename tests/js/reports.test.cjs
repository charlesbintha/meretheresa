const {test}=require('node:test');
const assert=require('node:assert/strict');
const vm=require('node:vm');
const fs=require('node:fs');
const path=require('node:path');
function setup(){
 const M={esc:String,actions:{},views:{},can:p=>['students.view','finance.view','grades.view'].includes(p),money:String,
  name:s=>`${s.firstName} ${s.lastName}`,db:{students:[{id:1,firstName:'Awa',lastName:'Diop',matricule:'001',classId:1,status:'Actif'},{id:2,firstName:'Ali',lastName:'Fall',matricule:'002',classId:2,status:'En attente'}],subjects:[{id:1,coefficient:2},{id:2,coefficient:1}],grades:{'1-1-1-test':10,'1-1-1-exam':16,'1-2-1-test':8,'1-2-1-exam':8},payments:[{id:1,studentId:1,date:'2026-03-01',method:'Wave',amount:100,reference:'P1'},{id:2,studentId:1,date:'2026-03-02',method:'Espèces',amount:200,reference:'P2'},{id:3,studentId:2,date:'2026-03-01',method:'Wave',amount:300,reference:'P3'}]}};
 M.student=id=>M.db.students.find(s=>s.id===id);M.cls=id=>({name:`Classe ${id}`});
 M.totalDue=s=>1000;M.paid=s=>s.id===1?400:1000;M.balance=s=>M.totalDue(s)-M.paid(s);
 vm.runInNewContext(fs.readFileSync(path.join(__dirname,'../../public/template/reports.js'),'utf8'),{MT:M,document:{addEventListener(){}}});
 return M;
}
test('payment filters combine class, inclusive dates, method and student search',()=>{
 const M=setup();const r=M.reporting.dataset({type:'payments',classId:'1',from:'2026-03-01',to:'2026-03-01',method:'Wave',query:'DIOP'});
 assert.equal(r.rows.length,1);assert.equal(r.rows[0][0],'P1');assert.equal(r.rows[0][6],100);
 assert.equal(M.reporting.dataset({type:'payments',query:'absent'}).rows.length,0);
});
test('averages use subject weights and distinguish missing marks from zero',()=>{
 const M=setup();assert.equal(M.reporting.average(1,'1'),12);assert.equal(M.reporting.average(1,'2'),null);
 Object.keys(M.db.grades).forEach(k=>M.db.grades[k]=0);assert.equal(M.reporting.average(1,'1'),0);
 const r=M.reporting.dataset({type:'grades',term:'1',result:'missing'});assert.equal(r.rows.length,1);assert.equal(r.rows[0][0],'002');
});
test('balance report filters actual outstanding tuition amounts',()=>{
 const M=setup();const r=M.reporting.dataset({type:'balances',result:'due'});assert.equal(r.rows.length,1);assert.equal(r.rows[0][5],600);
});
test('restricted roles cannot export financial or academic reports',()=>{
 const M=setup();M.can=p=>p==='students.view';for(const type of ['payments','balances','grades'])assert.equal(M.reporting.dataset({type}).rows.length,0);
 assert.equal(M.reporting.dataset({type:'students'}).rows.length,2);
});
