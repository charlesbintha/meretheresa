#!/usr/bin/env bash
# Run on Hostinger only after deploying the tested main branch. Refuses existing paths.
set -eu
umask 077
live=/home/u528935801/domains/lesbambinos.sn/public_html/app
demo=/home/u528935801/domains/lesbambinos.sn/horizon-demo
web="$live/public/demo"
test ! -e "$demo"
test ! -e "$web"
mkdir "$demo"
cd "$live"
git archive HEAD | tar -x -C "$demo"
cp -a vendor "$demo/vendor"
cd "$demo"
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs storage/app/private bootstrap/cache
php -r '$base=getcwd();$env="APP_NAME=\"Groupe scolaire Horizon\"\nAPP_ENV=production\nAPP_KEY=base64:".base64_encode(random_bytes(32))."\nAPP_DEBUG=false\nAPP_URL=https://app.lesbambinos.sn/demo\nAPP_TIMEZONE=Africa/Dakar\nAPP_LOCALE=fr\nSCHOOL_NAME=\"Groupe scolaire Horizon\"\nSCHOOL_DEMO=true\nSCHOOL_LOGO=template/assets/horizon-logo.svg\nDB_CONNECTION=sqlite\nDB_DATABASE=".$base."/database/horizon-demo.sqlite\nDB_FOREIGN_KEYS=true\nSESSION_DRIVER=database\nSESSION_COOKIE=horizon_demo_session\nSESSION_PATH=/demo\nSESSION_ENCRYPT=true\nSESSION_SECURE_COOKIE=true\nSESSION_SAME_SITE=lax\nCACHE_STORE=file\nCACHE_PREFIX=horizon_demo\nQUEUE_CONNECTION=sync\nMAIL_MAILER=log\nMAIL_FROM_ADDRESS=contact@horizon.example\nMAIL_FROM_NAME=\"Horizon Démonstration\"\nLOG_CHANNEL=stack\n";file_put_contents(".env",$env);touch("database/horizon-demo.sqlite");'
php artisan migrate --force
php artisan school:create-demo
mkdir "$web"
cp -a public/. "$web/"
cp deploy/horizon-index.php "$web/index.php"
find "$web" -type d -exec chmod 755 {} \;
find "$web" -type f -exec chmod 644 {} \;
chmod 600 .env database/horizon-demo.sqlite
php artisan config:cache
printf 'DEMO_READY\n'
