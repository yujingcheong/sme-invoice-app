import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();

  try {
    // Login
    console.log('Navigating to login...');
    await page.goto('http://127.0.0.1:8000/login');
    await page.fill('input[name="email"]', 'admin@sme-invoice.sg');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL('**/dashboard', { timeout: 10000 });
    console.log('✅ Login successful');

    // Test Dashboard
    console.log('Testing dashboard...');
    await page.goto('http://127.0.0.1:8000/dashboard');
    await page.waitForLoadState('networkidle');
    const dashboardText = await page.textContent('body');
    if (!dashboardText.includes('Total Revenue') && !dashboardText.includes('Dashboard')) {
      throw new Error('Dashboard not loaded correctly');
    }
    console.log('✅ Dashboard loads');

    // Test Customers
    console.log('Testing customers page...');
    await page.goto('http://127.0.0.1:8000/customers');
    await page.waitForLoadState('networkidle');
    const customersText = await page.textContent('body');
    if (!customersText.includes('Customers') && !customersText.includes('Temasek Solutions')) {
      throw new Error('Customers page not loaded correctly');
    }
    console.log('✅ Customers page loads');

    // Test Invoices
    console.log('Testing invoices page...');
    await page.goto('http://127.0.0.1:8000/invoices');
    await page.waitForLoadState('networkidle');
    const invoicesText = await page.textContent('body');
    if (!invoicesText.includes('Invoices') || !invoicesText.includes('INV-')) {
      throw new Error('Invoices page not loaded correctly');
    }
    console.log('✅ Invoices page loads');

    // Test Quotations
    console.log('Testing quotations page...');
    await page.goto('http://127.0.0.1:8000/quotations');
    await page.waitForLoadState('networkidle');
    const quotationsText = await page.textContent('body');
    if (!quotationsText.includes('Quotations') || !quotationsText.includes('QUO-')) {
      throw new Error('Quotations page not loaded correctly');
    }
    console.log('✅ Quotations page loads');

    // Test Portfolio (public)
    console.log('Testing portfolio page...');
    await page.goto('http://127.0.0.1:8000/portfolio');
    await page.waitForLoadState('networkidle');
    const portfolioText = await page.textContent('body');
    if (!portfolioText.includes('Business Systems Developer')) {
      throw new Error('Portfolio page not loaded correctly');
    }
    console.log('✅ Portfolio page loads');

    // Take screenshot
    await page.goto('http://127.0.0.1:8000/dashboard');
    await page.waitForLoadState('networkidle');
    await page.screenshot({ path: '.sisyphus/evidence/task-14-navigation.png', fullPage: true });
    console.log('✅ Screenshot saved');

    console.log('\n🎉 ALL NAVIGATION TESTS PASSED');
  } catch (error) {
    console.error('❌ TEST FAILED:', error.message);
    await page.screenshot({ path: '.sisyphus/evidence/task-14-error.png', fullPage: true });
    process.exit(1);
  } finally {
    await browser.close();
  }
})();
