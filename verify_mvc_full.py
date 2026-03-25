import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        # Test Home Page
        print("Taking screenshot of Home Page...")
        await page.goto("http://localhost:3000/")
        await page.wait_for_timeout(2000) # Wait for animations/dynamic data
        await page.screenshot(path="home_page.png", full_page=True)

        # Test Forum Page
        print("Taking screenshot of Forum Page...")
        await page.goto("http://localhost:3000/forum")
        await page.wait_for_timeout(2000)
        await page.screenshot(path="forum_page.png", full_page=True)

        # Test Events Page
        print("Taking screenshot of Events Page...")
        await page.goto("http://localhost:3000/events")
        await page.wait_for_timeout(2000)
        await page.screenshot(path="events_page.png", full_page=True)

        # Test Trainings Page
        print("Taking screenshot of Trainings Page...")
        await page.goto("http://localhost:3000/trainings")
        await page.wait_for_timeout(2000)
        await page.screenshot(path="trainings_page.png", full_page=True)

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
