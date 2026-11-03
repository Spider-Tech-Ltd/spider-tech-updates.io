#!/usr/bin/env bash
# ==============================================================================
# Remote Post-Deploy Composer Script (Runs on cPanel over SSH)
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

