#!/usr/bin/env bash
# Simple smoke test for local pages (requires php -S localhost:8000 running)
set -e
BASE="http://localhost:8000"
PAGES=("/" "/about" "/contact" "/faq" "/dashboard")

echo "Running smoke tests against $BASE"
for p in "${PAGES[@]}"; do
  echo -n "GET $p -> "
  status=$(curl -s -o /dev/null -w "%{http_code}" "$BASE$p" || true)
  echo "$status"
done

echo "Rendering dashboard with simulated session (CLI include)"
php -r "session_start(); \\$_SESSION['user_id']=1; \\$_SESSION['user_name']='Smoke Test'; \\$_SESSION['user_email']='smoke@local'; \\$_SESSION['user_role']='admin'; ob_start(); require 'views/dashboard_new.php'; file_put_contents('scripts/_dashboard_smoke.html', ob_get_clean()); echo 'Saved scripts/_dashboard_smoke.html';"

echo "Smoke tests complete."