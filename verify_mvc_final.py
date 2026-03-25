import asyncio
from playwright.async_api import async_playwright

async def run():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page()

        routes = [
            ("/", "home_v2.png"),
            ("/forum", "forum_v2.png"),
            ("/events", "events_list_v2.png"),
            ("/events/detail?id=1", "event_detail_v2.png"),
            ("/trainings", "trainings_list_v2.png"),
            ("/trainings/detail?id=1", "training_detail_v2.png"),
            ("/services", "services_list_v2.png"),
            ("/services/detail?id=1", "service_detail_v2.png"),
            ("/projects", "projects_list_v2.png"),
            ("/projects/detail?id=1", "project_detail_v2.png")
        ]

        for route, filename in routes:
            print(f"Taking screenshot of {route}...")
            try:
                await page.goto(f"http://localhost:3000{route}")
                await page.wait_for_timeout(1500)
                await page.screenshot(path=filename, full_page=True)
            except Exception as e:
                print(f"Failed to capture {route}: {e}")

        await browser.close()

if __name__ == "__main__":
    asyncio.run(run())
