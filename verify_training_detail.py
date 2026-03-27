import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        url = "http://localhost:3000/trainings/detail?id=1"
        print(f"Navigating to {url}...")

        await page.goto(url)
        await page.wait_for_timeout(2000) # Ensure content is rendered

        # Check if description and details are visible
        content = await page.content()
        if "Comprehensive course on modern web technologies" in content:
            print("Description found!")
        else:
            print("Description NOT found!")

        if "detailed content for Full Stack Web Development course" in content:
            print("Details found!")
        else:
            print("Details NOT found!")

        await page.screenshot(path="training_detail_verification.png", full_page=True)
        print("Screenshot saved to training_detail_verification.png")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
