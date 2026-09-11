// Run against an isolated, seeded test database; never a production URL.
const {chromium}=require('playwright');
const assert=require('node:assert/strict');
(async()=>{
 const url=process.env.SCHOOL_TEST_URL;
 if(!url||!/^http:\/\/(127\.0\.0\.1|localhost):\d+$/.test(url))throw Error('Set SCHOOL_TEST_URL to an isolated local server.');
 if(!process.env.SCHOOL_TEST_EMAIL||!process.env.SCHOOL_TEST_PASSWORD)throw Error('Test credentials required.');
 const browser=await chromium.launch({headless:true,channel:process.env.PLAYWRIGHT_CHANNEL||'chrome'});
 const page=await browser.newPage({viewport:{width:1440,height:1000},reducedMotion:'reduce'});const errors=[];
 page.on('pageerror',error=>errors.push(error.message));
 try{
  await page.goto(url);await page.locator('[name=email]').fill(process.env.SCHOOL_TEST_EMAIL);await page.locator('[name=password]').fill(process.env.SCHOOL_TEST_PASSWORD);await page.locator('[type=submit]').click();
  await page.waitForFunction(()=>window.MT?.ready===true);
  const routes=await page.evaluate(()=>Object.keys(MT.views));
  for(const route of routes){await page.evaluate(r=>MT.navigate(r),route);await page.locator('h1').waitFor();assert(!(await page.locator('#main').innerText()).includes('undefined'),route);}
  await page.evaluate(()=>MT.navigate('students'));await page.locator('[data-action=student-form]').first().click();
  const f=page.locator('form[data-form=student]');
  for(const [name,value] of Object.entries({firstName:'UI',lastName:'Persistance',birth:'2018-01-01',parent:'Parent UI',phone:'770000000',email:'ui-parent@example.test',address:'Dakar'}))await f.locator(`[name=${name}]`).fill(value);
  await f.locator('[name=classId]').selectOption('1');await f.locator('[type=submit]').click();await page.waitForFunction(()=>MT.db.students.some(s=>s.lastName==='Persistance'));
  const id=await page.evaluate(()=>MT.db.students.find(s=>s.lastName==='Persistance').id);
  await page.reload();await page.waitForFunction(()=>MT.ready);assert(await page.evaluate(id=>MT.db.students.some(s=>s.id===id),id));
  await page.evaluate(id=>MT.actions['payment-form']({dataset:{student:String(id)}}),id);
  const pay=page.locator('form[data-form=payment]');await pay.locator('[name=amount]').fill('40000');await pay.locator('[name=date]').fill('2026-03-16');await pay.locator('[type=submit]').click();await page.locator('#modal-title').filter({hasText:'Reçu de paiement'}).waitFor();
  await page.reload();await page.waitForFunction(()=>MT.ready);assert.equal(await page.evaluate(id=>MT.balance(MT.student(id)),id),110000);
  await page.evaluate(()=>MT.navigate('grades'));await page.locator('[data-change=grade-class]').selectOption('1');
  const test=page.locator(`[data-student="${id}"][data-grade=test]`),exam=page.locator(`[data-student="${id}"][data-grade=exam]`);
  assert.equal(await test.inputValue(),'');await test.fill('18');await exam.fill('15');await page.locator('[data-action=save-grades]').click();await page.waitForFunction(id=>MT.db.grades[`${id}-1-2-test`]===18,id);
  await page.reload();await page.waitForFunction(()=>MT.ready);assert.equal(await page.evaluate(id=>MT.average(id,1),id),16);
  await page.evaluate(()=>MT.actions['year-activate']({dataset:{id:'2'}}));await page.waitForFunction(()=>MT.db.activeYear===2);assert.equal(await page.evaluate(()=>MT.db.students.length),0);
  for(const route of routes){await page.evaluate(r=>MT.navigate(r),route);assert(!(await page.locator('#main').innerHTML()).match(/undefined|NaN/),route+' empty state');}
  await page.evaluate(()=>MT.actions['year-activate']({dataset:{id:'1'}}));await page.waitForFunction(()=>MT.db.activeYear===1);
  await page.evaluate(()=>MT.navigate('dashboard'));await page.screenshot({path:'/private/tmp/mere-teresa-connected.png',fullPage:true});
  await page.setViewportSize({width:390,height:844});assert(await page.evaluate(()=>document.documentElement.scrollWidth<=innerWidth+1),'Mobile overflow');
  assert.deepEqual(errors,[]);console.log(`${routes.length} pages, creation/reload, payment balance, grades and year isolation: passed.`);
 }finally{await browser.close();}
})().catch(error=>{console.error(error);process.exit(1)});
