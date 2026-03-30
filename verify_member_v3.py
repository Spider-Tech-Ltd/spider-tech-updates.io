import asyncio
from playwright.async_api import async_playwright

async def verify_member_flow():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        context = await browser.new_context(viewport={'width': 1920, 'height': 1080})
        page = await context.new_page()

        # 1. Visit Sign Up Page
        print("Visiting Sign Up Page...")
        await page.goto("http://localhost:3000/forum/sign-up")

        # 2. Register a new user
        print("Registering new user...")
        await page.fill("input[name='name']", "Jules Engineer")
        await page.fill("input[name='username']", "jules_eng")
        await page.fill("input[name='email']", "jules@example.com")
        await page.fill("input[name='password']", "SecurePass123!")
        await page.click("button[type='submit']")

        await page.wait_for_timeout(2000)
        await page.screenshot(path="member_feed_after_reg.png")
        print(f"Current URL after reg: {page.url}")

        # 3. Verify personalized content
        banner_text = await page.locator(".banner-greeting").inner_text()
        print(f"Banner greeting: {banner_text}")
        if "Jules Engineer" in banner_text:
            print("SUCCESS: Personalized greeting found.")
        else:
            print("FAILURE: Personalized greeting NOT found.")

        # 4. Verify "Start a Discussion" button in Hero (Forum Index)
        await page.goto("http://localhost:3000/forum")
        await page.wait_for_timeout(1000)
        start_discussion_btn = page.locator("a.hero-btn-primary:has-text('Start a Discussion')")
        if await start_discussion_btn.is_visible():
            print("SUCCESS: 'Start a Discussion' button is visible for member.")
        else:
            print("FAILURE: 'Start a Discussion' button NOT visible for member.")

        sign_in_btn = page.locator("a.hero-btn-secondary:has-text('Sign In')")
        if not await sign_in_btn.is_visible():
            print("SUCCESS: 'Sign In' button is hidden for member.")
        else:
            print("FAILURE: 'Sign In' button STILL visible for member.")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(verify_member_flow())
