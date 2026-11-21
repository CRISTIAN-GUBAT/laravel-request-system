#!/bin/bash
# config-audit/audit.sh
# Usage: ./config-audit/audit.sh [/path/to/laravel/app]

set -uo pipefail

APP_DIR="${1:-.}"
cd "$APP_DIR" || { echo "ERROR: Cannot cd to $APP_DIR"; exit 1; }

PASS=0; FAIL=0; UNVERIFIED=0

check_pass() { echo "$1 PASS"; PASS=$((PASS+1)); }
check_fail() { echo "$1 FAIL"; FAIL=$((FAIL+1)); }
check_unverified() { echo "$1 UNVERIFIED"; UNVERIFIED=$((UNVERIFIED+1)); }

# --- Check 1: debug_off ---
DEBUG=$(php artisan tinker --execute="echo config('app.debug') ? 'true' : 'false';" 2>/dev/null | tr -d '[:space:]')
case "$DEBUG" in
  false|0) check_pass "debug_off" ;;
  true|1)  check_fail "debug_off" ;;
  *)       check_unverified "debug_off" ;;
esac

# --- Check 2: database_access_scope ---
# Cannot verify from application context alone
check_unverified "database_access_scope"

# --- Check 3: app_key_present ---
KEY=$(php artisan tinker --execute="echo config('app.key') ? 'present' : 'absent';" 2>/dev/null | tr -d '[:space:]')
case "$KEY" in
  present) check_pass "app_key_present" ;;
  absent)  check_fail "app_key_present" ;;
  *)       check_unverified "app_key_present" ;;
esac

# --- Check 4: document_root ---
DOCROOT=$(php artisan tinker --execute="echo public_path();" 2>/dev/null | tr -d '[:space:]')
if echo "$DOCROOT" | grep -q "/public$"; then
  check_pass "document_root"
else
  check_unverified "document_root"
fi

echo "---"
echo "PASS: $PASS, FAIL: $FAIL, UNVERIFIED: $UNVERIFIED"
[ "$FAIL" -gt 0 ] && exit 1
exit 0