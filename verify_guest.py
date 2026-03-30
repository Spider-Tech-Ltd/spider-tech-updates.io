import asyncio
from playwright.async_api import async_playwright

async def verify_guest_view():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        context = await browser.new_context(viewport={'width': 1920, 'height': 1080})
        page = await context.new_page()

        # 1. Visit Guest Forum Index
        print("Visiting Guest Forum Index...")
        await page.goto("http://localhost:3000/forum")
        await page.wait_for_timeout(1000) # Wait for animation
        await page.screenshot(path="guest_forum_index.png")

        # 2. Check for Sign In button in Hero
        sign_in_btn = page.locator("a.hero-btn-secondary:has-text('Sign In')")
        if await sign_in_btn.is_visible():
            print("SUCCESS: 'Sign In' button is visible for guest.")
        else:
            print("FAILURE: 'Sign In' button NOT visible for guest.")

        # 3. Check for Category Grid
        categories = page.locator(".category-card")
        count = await categories.count()
        print(f"Found {count} categories.")

        # 4. Visit Sign In Page
        print("Visiting Sign In Page...")
        await page.goto("http://localhost:3000/forum/sign-in")
        await page.wait_for_timeout(1000)
        await page.screenshot(path="guest_sign_in.png")

        # 5. Visit Sign Up Page
        print("Visiting Sign Up Page...")
        await page.goto("http://localhost:3000/forum/sign-up")
        await page.wait_for_timeout(1000)
        await page.screenshot(path="guest_sign_up.png")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(verify_guest_view())
