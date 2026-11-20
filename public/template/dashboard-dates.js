(()=>{
const M=MT,day=86400000,iso=d=>d.toISOString().slice(0,10),stamp=s=>Date.parse(s+'T00:00:00Z');
M.dashboardRange=()=>{
 const year=M.db.years.find(y=>y.active),key=year?.id??'';
 if(!M.view.dateStart||M.view.dateYear!==key){
  const today=new Date().toLocaleDateString('sv-SE');
  let end=today,start=today.slice(0,8)+'01';
  if(year?.start&&year?.end){if(today<year.start||today>year.end){start=year.start;end=year.end;}else start=start<year.start?year.start:start;}
  Object.assign(M.view,{dateStart:start,dateEnd:end,dateYear:key});
 }
 return {start:M.view.dateStart,end:M.view.dateEnd};
};
M.dashboardPayments=()=>{const {start,end}=M.dashboardRange();return M.db.payments.filter(p=>p.date&&p.date>=start&&p.date<=end);};
M.dashboardRangeLabel=()=>{const r=M.dashboardRange();return `du ${M.date(r.start)} au ${M.date(r.end)}`;};
M.chartBuckets=()=>{
 const {start,end}=M.dashboardRange(),a=stamp(start),days=Math.round((stamp(end)-a)/day)+1;
 if(!Number.isFinite(days)||days<1)return [];
 const count=Math.min(7,days),buckets=Array.from({length:count},(_,i)=>({start:iso(new Date(a+Math.ceil(i*days/count)*day)),end:iso(new Date(a+(Math.ceil((i+1)*days/count)-1)*day)),amount:0}));
 for(const p of M.dashboardPayments()){const b=buckets.find(b=>p.date>=b.start&&p.date<=b.end);if(b)b.amount+=Number(p.amount);}
 return buckets;
};
M.chartValues=()=>M.chartBuckets().map(b=>b.amount);
M.chartBucketLabel=i=>{const b=M.chartBuckets()[i];return b?`${M.date(b.start)} – ${M.date(b.end)}`:'';};
})();
