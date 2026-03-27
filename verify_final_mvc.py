import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        # Test 1: Program Detail Link
        print("Testing link from Program Detail to Register...")
        await page.goto("http://localhost:3000/trainings/detail?id=1")
        await page.click("text=Register Now")
        await page.wait_for_timeout(2000)

        if "/trainings/register?id=1" in page.url:
            print("Link to register page works!")
        else:
            print(f"Link failed. Current URL: {page.url}")

        # Test 2: Dynamic Form Rendering
        print("Verifying dynamic form fields...")
        content = await page.content()
        if 'name="full_name"' in content and 'name="email"' in content:
            print("Dynamic fields found!")
        else:
            print("Dynamic fields NOT found!")

        # Test 3: Fallback (if id not 1 or fields empty - using id=99)
        print("Testing fallback form...")
        await page.goto("http://localhost:3000/trainings/register?id=99")
        await page.wait_for_timeout(1000)
        content = await page.content()
        if 'name="firstname"' in content:
            print("Fallback form fields found!")

        # Final screenshots
        await page.goto("http://localhost:3000/trainings/register?id=1")
        await page.screenshot(path="final_reg_v3.png", full_page=True)

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
