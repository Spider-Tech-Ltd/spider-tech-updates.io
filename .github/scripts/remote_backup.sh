#!/usr/bin/env bash
# ==============================================================================
# Remote Pre-Deploy Backup Script (Runs on cPanel over SSH)
# Argument 1: DEPLOY_PATH
# ==============================================================================
set -euo pipefail

DEPLOY_PATH="${1:-}"
if [ -z "$DEPLOY_PATH" ]; then
  echo "Error: DEPLOY_PATH argument missing."
  exit 1
fi

BACKUP_PARENT="$(dirname "$DEPLOY_PATH")"
BACKUP_DIR="${BACKUP_PARENT}/deploy_backups"
mkdir -p "$BACKUP_DIR"

if [ -d "$DEPLOY_PATH" ] && [ "$(ls -A "$DEPLOY_PATH" 2>/dev/null)" ]; then
  TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
  BACKUP_FILE="${BACKUP_DIR}/backup_${TIMESTAMP}.tar.gz"
  echo "Creating timestamped backup: ${BACKUP_FILE}"

  tar --exclude='storage/receipts' \
      --exclude='uploads' \
      --exclude='images/registrations' \
      --exclude='images/pictures' \
      -czf "${BACKUP_FILE}" -C "$DEPLOY_PATH" .
  
  # Retain only the 5 most recent backups
  cd "$BACKUP_DIR"
  ls -t backup_*.tar.gz | tail -n +6 | xargs -r rm -f
  echo "Backup complete. Retained last 5 backups:"
  ls -lh backup_*.tar.gz
else
  echo "Deploy directory is empty or not created yet; skipping initial backup."
fi

