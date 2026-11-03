#!/usr/bin/env bash
# ==============================================================================
# Remote Post-Deploy Composer & Migration Script (Runs on cPanel over SSH)
# Argument 1: DEPLOY_PATH
# ==============================================================================
set -euo pipefail

DEPLOY_PATH="${1:-}"
if [ -z "$DEPLOY_PATH" ]; then
  echo "Error: DEPLOY_PATH argument missing."
  exit 1
fi

cd "$DEPLOY_PATH"

if command -v composer >/dev/null 2>&1; then
  echo "Running 'composer install --no-dev --optimize-autoloader' on server..."
  composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
else
  echo "Composer command not found globally; skipping remote composer install."
fi

# Run idempotent database migrations to keep production schema synchronized
if command -v php >/dev/null 2>&1; then
  echo "Applying production database migrations..."
  if [ -f "database/migrations/create_training_cohorts_table.php" ]; then
    php database/migrations/create_training_cohorts_table.php || true
  fi
  if [ -f "database/migrations/add_topbar_banner_to_cohorts.php" ]; then
    php database/migrations/add_topbar_banner_to_cohorts.php || true
  fi
  if [ -f "database/migrations/add_paystack_payments.php" ]; then
    php database/migrations/add_paystack_payments.php || true
  fi
  echo "Production database migrations completed."
fi
