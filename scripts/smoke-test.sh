#!/bin/bash
# scripts/smoke-test.sh
# Usage: ./scripts/smoke-test.sh https://[STAGING-URL]
BASE_URL="${1:-http://127.0.0.1:8000}"
PASS=0; FAIL=0

test_result() {
  if [ "$2" = "$3" ]; then
    echo "[PASS] $1 (expected=$2, actual=$3)"
    PASS=$((PASS+1))
  else
    echo "[FAIL] $1 (expected=$2, actual=$3)"
    FAIL=$((FAIL+1))
  fi
}

echo "=== Smoke Tests: $BASE_URL ==="

# 1. Health check
HEALTH=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/health")
test_result "Health check" "200" "$HEALTH"

# 2. Login page
LOGIN=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/login")
test_result "Login page" "200" "$LOGIN"

# 3. Requests page (unauthenticated → redirect to login)
REQ=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/requests")
test_result "Requests (unauthenticated)" "302" "$REQ"

# 4. Create form (unauthenticated → redirect)
CREATE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/requests/create")
test_result "Create form (unauthenticated)" "302" "$CREATE"

# 5. Dashboard (unauthenticated → redirect)
DASH=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/dashboard")
test_result "Dashboard (unauthenticated)" "302" "$DASH"

echo "---"
echo "PASS: $PASS, FAIL: $FAIL"
[ "$FAIL" -gt 0 ] && exit 1
exit 0