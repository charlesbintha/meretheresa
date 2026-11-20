const {test}=require('node:test');
const assert=require('node:assert/strict');
const vm=require('node:vm');
const fs=require('node:fs');
function setup(start,end){const M={view:{dateYear:1,dateStart:start,dateEnd:end},date:String,db:{years:[{id:1,active:true,start:'2027-10-01',end:'2028-06-30'}],payments:[]}};vm.runInNewContext(fs.readFileSync('public/template/dashboard-dates.js','utf8'),{MT:M});return M;}
test('date range includes both endpoints, excludes undated payments and counts each receipt once',()=>{
 const M=setup('2028-02-28','2028-03-01');M.db.payments=[{date:'2028-02-27',amount:99},{date:'2028-02-28',amount:'10'},{date:'2028-02-29',amount:20},{date:'2028-03-01',amount:30},{date:'2028-03-02',amount:99},{date:'',amount:99}];
 assert.equal(M.dashboardPayments().length,3);assert.equal(M.chartBuckets().length,3);assert.equal(M.chartValues().join(','),'10,20,30');
});
test('seven contiguous buckets span a long range and support a single day',()=>{const M=setup('2027-12-20','2028-03-10');const b=M.chartBuckets();assert.equal(b.length,7);assert.equal(b[0].start,'2027-12-20');assert.equal(b[6].end,'2028-03-10');for(let i=1;i<b.length;i++)assert.equal(Date.parse(b[i].start)-Date.parse(b[i-1].end),86400000);M.view.dateStart=M.view.dateEnd;assert.equal(M.chartBuckets().length,1);});
test('changing academic year resets the range into the selected year',()=>{const M=setup('2028-02-01','2028-02-29');M.db.years=[{id:2,active:true,start:'2020-10-01',end:'2021-06-30'}];assert.equal(M.dashboardRange().start,'2020-10-01');assert.equal(M.dashboardRange().end,'2021-06-30');});
