# Spider Technologies Website (`spider_tech_updates`)

Industrial website and forum application built with vanilla PHP, Bootstrap, and Alpine.js.

## Requirements
- PHP 8.2 or higher
- Composer 2.x
- MySQL / MariaDB

## Local Development Setup

1. **Clone the repository:**
   ```bash
   git clone <repo-url>
   cd spider_tech_updates
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   Copy the example environment file and update your credentials:
   ```bash
   cp .env.example .env
   ```

4. **Enable Git Pre-Commit Security & Syntax Hook:**
   Run this one-time command so Git automatically runs `php -l` and secret scans before every commit:
   ```bash
   git config core.hooksPath .githooks
   ```

5. **Run Tests & Static Analysis:**
   ```bash
   # Run PHPUnit tests
   ./vendor/bin/phpunit

   # Run PHPStan static analysis
   ./vendor/bin/phpstan analyse --memory-limit 512M
   ```
