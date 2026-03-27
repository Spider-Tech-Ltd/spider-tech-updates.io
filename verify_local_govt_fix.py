import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        url = "http://localhost:3000/trainings/register?id=3"
        print(f"Navigating to {url}...")

        await page.goto(url)
        await page.wait_for_timeout(2000)

        # Check if local government options are present
        content = await page.content()
        options = ['Kano Municipal', 'Tarauni', 'Nassarawa', 'Gwale', 'Fagge']
        found_all = True
        for option in options:
            if option in content:
                print(f"Option '{option}' found!")
            else:
                print(f"Option '{option}' NOT found!")
                found_all = False

        if found_all:
            print("All local government options are verified.")
        else:
            print("Some options are still missing.")

        await page.screenshot(path="local_govt_fix_verification.png", full_page=True)
        print("Screenshot saved to local_govt_fix_verification.png")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
