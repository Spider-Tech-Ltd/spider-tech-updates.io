# CI/CD Pipeline & Deployment Guide

This document explains the architecture, security safeguards, configuration, and operational procedures for the continuous integration and deployment pipeline of `spider_tech_updates`.

---

## 1. Pipeline Architecture & Workflow

The pipeline utilizes **GitHub Actions** as a security gate and continuous deployment engine:

```
                  ┌──────────────────────────────────────────┐
                  │ Push to feature/** or Pull Request to main│
                  └────────────────────┬─────────────────────┘
                                       │
                                       ▼
                   ┌───────────────────────────────────────┐
                   │           Job: Verify                 │
                   │  - PHP 8.2 setup & Composer validate  │
                   │  - Syntax lint (php -l on all files)   │
                   │  - PHPUnit test suite (Smoke/Unit)    │
                   │  - PHPStan static analysis (Level 1)  │
                   │  - Composer audit & Gitleaks scan     │
                   │  - Block committed .env/private keys  │
                   │  - Debug leftovers audit (var_dump)   │
                   └───────────────────┬───────────────────┘
                                       │
                              [Pass Required]
                                       │
                 ┌─────────────────────┴────────────────────┐
                 │ Merged to main branch (or dry-run trigger)│
                 └─────────────────────┬────────────────────┘
                                       │
                                       ▼
                   ┌───────────────────────────────────────┐
                   │    Job: Deploy to Production           │
                   │    (GitHub Environment: production)   │
                   │  - Strict SSH key injection           │
                   │  - Pre-deploy backup on cPanel        │
                   │  - rsync -az --delete (with excludes) │
                   │  - Remote composer install            │
                   │  - Automated health check (HTTP 200)  │
                   │  - Shred & clean temporary keys       │
                   └───────────────────────────────────────┘
```

### Key Safety Mechanisms
1. **Gate enforcement**: The `deploy` job strictly `needs: verify`. If any test, linter, or security audit fails, deployment never executes.
2. **Ref isolation**: The `deploy` job only triggers on `push` to `main` (never on PRs or feature branches).
3. **Concurrency control**: Any newer commit pushed to the same branch automatically cancels superseded CI runs to conserve runner minutes.
4. **Secret hygiene**: SSH keys are generated as temporary files with `chmod 600`, host keys are strictly verified (`StrictHostKeyChecking` cannot be bypassed), and keys are shredded in an `always()` cleanup step.

---

## 2. GitHub Secrets & Variables Configuration

Go to your repository on GitHub: **Settings > Secrets and variables > Actions**.

### Required Secrets (under "Repository secrets" or "Environment secrets: production")

| Secret Name | Description | Example / Instructions |
| :--- | :--- | :--- |
| `SSH_HOST` | Hostname or IP address of your cPanel server | `server.spidertech.com.ng` or `198.51.100.24` |
| `SSH_PORT` | SSH port configured on your cPanel account | `22` (default) or custom port (e.g., `2222`) |
| `SSH_USER` | cPanel SSH username | `spidertech` |
| `SSH_PRIVATE_KEY` | Dedicated OpenSSH ed25519 or RSA private key | `-----BEGIN OPENSSH PRIVATE KEY-----...` |
| `SSH_KNOWN_HOSTS` | Output from `ssh-keyscan` pinned for host verification | `server.spidertech.com.ng ssh-ed25519 AAAAC3N...` |
| `DEPLOY_PATH` | Absolute path to the web root on cPanel | `/home/cpaneluser/public_html` |
| `HEALTH_CHECK_URL` | Public URL to verify site health after deploy | `https://spidertech.com.ng/health` |
| `GITLEAKS_LICENSE` | License key from gitleaks.io for secret scanning | `your_gitleaks_license_key` |

> [!NOTE]
> `HEALTH_CHECK_URL` can also be stored as a GitHub Actions **Variable** (non-secret) instead of a Secret.

---

## 3. Server-Side SSH & cPanel Setup

### Step 3.1: Generate a Dedicated Deploy Key Pair
Run this on your local machine (or in a secure terminal). **Never reuse personal SSH keys**:
```bash
ssh-keygen -t ed25519 -C "github-actions-deploy@spidertech" -f spider_deploy_key
```
This generates:
- `spider_deploy_key` (Private key → Paste into GitHub Secret `SSH_PRIVATE_KEY`)
- `spider_deploy_key.pub` (Public key → Add to cPanel)

### Step 3.2: Authorize Public Key on cPanel
1. Log in to your **cPanel** dashboard.
2. Under **Security**, click **SSH Access > Manage SSH Keys**.
3. Click **Import Key**, paste the contents of `spider_deploy_key.pub`, and give it a name (e.g. `github-actions-deploy`).
4. Click **Manage** next to the imported key and click **Authorize**.
*(Alternative via terminal if you already have SSH access: `cat spider_deploy_key.pub >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys`)*.

### Step 3.3: Obtain `SSH_KNOWN_HOSTS`
To prevent man-in-the-middle attacks, capture the host key fingerprint:
```bash
ssh-keyscan -p <SSH_PORT> -H <SSH_HOST>
```
Copy the full output lines and save as GitHub Secret `SSH_KNOWN_HOSTS`.

### Step 3.4: Production `.env` and `db_config.php`
On cPanel inside your `DEPLOY_PATH` (`/home/username/public_html`):
1. Create your production `.env` file containing live credentials (e.g., live Paystack keys).
2. Ensure permissions are restricted: `chmod 600 .env`.
3. Because `.rsync-exclude` excludes `.env` and `config/db_config.php`, **your server-side credentials will never be overwritten or deleted by automated deployments**.

---

## 4. GitHub Environment Setup

1. In GitHub, navigate to **Settings > Environments**.
2. Click **New environment** and name it `production`.
3. (Optional / Recommended) Enable **Required reviewers** if you want manual sign-off before production deploys execute.
4. You may place `DEPLOY_PATH`, `HEALTH_CHECK_URL`, or production-specific secrets inside this environment.

---

## 5. Branch Protection Ruleset (Main Branch)

To enforce that no code reaches `main` without passing CI:

1. Navigate to **Settings > Rules > Rulesets**.
2. Click **New ruleset > New branch ruleset**.
3. Fill out the configuration:
   - **Ruleset Name**: `Protect Main Branch`
   - **Enforcement status**: `Active`
   - **Bypass list**: Leave **Empty** (no exceptions).
   - **Target branches**: Select **Add default branch** (`main`).
4. Enable the following branch rules:
   - ✅ **Restrict deletions**: Prevents deleting the `main` branch.
   - ✅ **Block force pushes**: Prevents rewriting history.
   - ✅ **Require a pull request before merging**:
     - Required approvals: `1` (or `0` if solo dev, but PR is still required).
     - Dismiss stale pull request approvals when new commits are pushed: Checked.
   - ✅ **Require status checks to pass**:
     - Check: **`Verify`** (Type `Verify` into the search box and select it).
     - Require branches to be up to date before merging: Checked.
5. Click **Create** / **Save changes**.

> [!IMPORTANT]
> **GitHub Plan Limits**:
> - **Public Repositories**: Branch protection and Rulesets are **100% free** with all features included.
> - **Private Repositories**: Advanced branch rulesets and branch protection on private repositories require a GitHub Pro, Team, or Enterprise plan. If your repo is private on GitHub Free, you can upgrade or convert to public to enforce required status checks.

---

## 6. How to Roll Back a Deployment (< 5 Minutes)

Before every deployment, the pipeline automatically takes a timestamped compressed backup of the deployment directory on cPanel (excluding user uploads to save disk space) and preserves the last 5 backups in `../deploy_backups/`.

### Emergency Rollback Procedure:
If a deployment ever introduces a severe bug, log in to cPanel terminal (or connect via SSH) and run:

```bash
# 1. Inspect available backups
cd ~/deploy_backups && ls -lh

# 2. Restore the previous backup into public_html
tar -xzf ~/deploy_backups/backup_YYYYMMDD_HHMMSS.tar.gz -C ~/public_html

# 3. Re-run composer if dependencies changed
cd ~/public_html && composer install --no-dev --optimize-autoloader

# 4. Verify the site
curl -I https://spidertech.com.ng/health
```

The rollback restores application code in seconds without touching user uploads in `uploads/`, `images/`, or `.env`.

---

## 7. How to Add a New CI Check

All checks run inside the `Verify` job in [`.github/workflows/ci.yml`](file:///.github/workflows/ci.yml). To add a new check:

1. Add the tool to `composer.json` under `require-dev` (if it is a PHP tool), or run it as a CLI step.
2. Add a new step in `.github/workflows/ci.yml` under `jobs.verify.steps`:
   ```yaml
   - name: Run My New Linter
     run: ./vendor/bin/my-tool --check
   ```
3. Test locally first before pushing:
   ```bash
   composer install
   ./vendor/bin/my-tool --check
   ```

---

## 8. Proposed Production `.htaccess` Hardening

Below is a proposed hardening template for your production `.htaccess`. Review and merge these rules into your server's `.htaccess`:

```apache
# ==============================================================================
# SPIDER TECH PRODUCTION HARDENING RECOMMENDATIONS
# ==============================================================================

# 1. Disable Directory Browsing
Options -Indexes

# 2. Prevent Access to Dotfiles and Hidden Files (.env, .git, etc.)
<FilesMatch "^\.">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>

# 3. Block Direct HTTP Access to Sensitive Configuration and Maintenance Files
<FilesMatch "(^db_config\.php|\.neon$|\.xml$|\.log$|\.sql$|composer\.(json|lock)|package(-lock)?\.json|repair_.*\.php|sync_database\.php|reset_admin\.php)">
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
    </IfModule>
</FilesMatch>

# 4. Block Direct Execution of Scripts in Upload / Storage Folders
<DirectoryMatch "^.*/(uploads|storage|images)/.*">
    <FilesMatch "\.(php|phtml|php3|php4|php5|php7|phps|cgi|pl|py|sh)$">
        <IfModule mod_authz_core.c>
            Require all denied
        </IfModule>
        <IfModule !mod_authz_core.c>
            Order allow,deny
            Deny from all
        </IfModule>
    </FilesMatch>
</DirectoryMatch>

# 5. Modern Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

---

## 9. Verification & Acceptance Checklist

To verify and prove the pipeline works end-to-end:

### Test A: Feature Branch Push (Only Verify Runs)
1. Push branch `feature/ci-cd-pipeline` to GitHub:
   ```bash
   git push origin feature/ci-cd-pipeline
   ```
2. Go to **Actions** in GitHub:
   - Notice only the **Verify** job runs.
   - The **Deploy** job is skipped.

### Test B: Deliberate Syntax Error on PR (Gate Blocks Merge)
1. Create a throwaway branch `feature/test-gate`:
   ```bash
   git checkout -b feature/test-gate
   ```
2. Introduce a deliberate syntax error (e.g. `bad_syntax_here;` in a test PHP file) and commit it.
3. Open a Pull Request from `feature/test-gate` into `main`.
4. Observe:
   - GitHub Actions runs `Verify`.
   - The syntax lint step fails.
   - The PR status check `Verify` reports red (failure).
   - The "Merge" button is blocked by GitHub.

### Test C: Fix and Merge (Automated Deployment & Health Check)
1. Fix the syntax error and push to the PR branch.
2. Observe:
   - `Verify` passes and turns green.
3. Merge the Pull Request into `main`.
4. Observe:
   - `Verify` runs on `main` and passes.
   - `Deploy to Production` automatically triggers.
   - Pre-deploy backup is created on cPanel.
   - Files are synchronized via `rsync`.
   - Health check runs against `${HEALTH_CHECK_URL}` and returns HTTP 200.

