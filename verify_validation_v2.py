import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        url = "http://localhost:3000/trainings/register?id=3"
        print(f"Navigating to {url}...")
        await page.goto(url)
        await page.wait_for_timeout(1000)

        # 1. Test Required Fields & Formatting
        print("Testing required fields and invalid email...")
        # Fill name but leave email empty or invalid
        await page.fill('input[name="full_name"]', "Test User")
        await page.fill('input[name="email"]', "invalid-email")

        await page.click("button.submit-btn")
        await page.wait_for_timeout(2000)

        # Take screenshot of error highlights
        await page.screenshot(path="validation_errors_highlight.png", full_page=True)
        print("Screenshot of validation errors saved.")

        # Verify specific error messages in content
        content = await page.content()
        if "Please enter a valid email address" in content:
            print("Email format error found!")
        if "Local Government is required" in content:
            print("Required field error found!")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
