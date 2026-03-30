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
        await page.wait_for_timeout(2000) # Wait for animation and server response
        await page.screenshot(path="guest_forum_index_debug.png")

        # 2. Check for Sign In button in Hero
        # Looking for the button in the hero section based on the updated hero.php
        sign_in_btn = page.locator("a.hero-btn-secondary:has-text('Sign In')")
        is_visible = await sign_in_btn.is_visible()
        print(f"'Sign In' button visibility: {is_visible}")

        # 3. Check for Category Grid
        categories = page.locator(".forum-category-card")
        count = await categories.count()
        print(f"Found {count} categories.")

        # 4. Visit Sign In Page
        print("Visiting Sign In Page...")
        await page.goto("http://localhost:3000/forum/sign-in")
        await page.wait_for_timeout(1000)
        await page.screenshot(path="guest_sign_in_debug.png")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(verify_guest_view())
