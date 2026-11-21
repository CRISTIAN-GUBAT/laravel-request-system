# Configuration Audit

## Files
- `baseline.example` — non-secret baseline (safe to commit)
- `audit.sh` — compares effective Laravel settings vs baseline
- `permissions.sh` — permission/exposure checklist helper

## Usage
```bash
chmod +x config-audit/*.sh scripts/*.sh
./config-audit/audit.sh /path/to/app
./config-audit/permissions.sh /path/to/app