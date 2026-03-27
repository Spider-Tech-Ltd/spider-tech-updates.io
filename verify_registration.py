import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        # Test Registration Page
        url = "http://localhost:3000/trainings/register?id=1"
        print(f"Navigating to {url}...")
        await page.goto(url)
        await page.wait_for_timeout(2000)

        # Take screenshot of registration page
        await page.screenshot(path="registration_form.png", full_page=True)
        print("Registration form screenshot saved.")

        # Test fallback form submission (triggering error messages if fields empty)
        print("Testing form submission...")
        await page.click("button.submit-btn")
        await page.wait_for_timeout(1000)

        # Take screenshot after submission
        await page.screenshot(path="registration_submission_check.png", full_page=True)
        print("Submission check screenshot saved.")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
