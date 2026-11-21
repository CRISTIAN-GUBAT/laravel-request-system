#!/bin/bash
# config-audit/permissions.sh
APP_DIR="${1:-.}"

echo "=== Document Root ==="
ls -ld "$APP_DIR/public"
echo "Expected: web server serves $APP_DIR/public"

echo ""
echo "=== Writable Paths ==="
ls -ld "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"

echo ""
echo "=== Service Identity ==="
ps aux | grep -E 'php-fpm|nginx|apache' | grep -v grep || echo "Not running as service (local dev)"

echo ""
echo "=== Exposed Ports ==="
ss -tlnp 2>/dev/null || netstat -tlnp 2>/dev/null || echo "ss/netstat unavailable"

echo ""
echo "=== MySQL Bind Address ==="
ss -tlnp 2>/dev/null | grep 3306 || echo "MySQL port not visible from here"

echo ""
echo "=== TLS Certificate (manual) ==="
echo "Run: openssl s_client -connect [STAGING-HOST]:443 -servername [STAGING-HOST] </dev/null 2>/dev/null | openssl x509 -noout -subject -dates"