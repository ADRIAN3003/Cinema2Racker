#!/bin/bash
# Cinema2Racker - frissito script a Nethely szerverre.
# Hasznalat (a projekt mappajaban): ./update.sh
set -e

cd "$(dirname "$0")"

# A szerveren a CLI alapertelmezett PHP-je 7.4, a Laravel 12-hoz 8.2+ kell.
PHP=/usr/bin/php8.3
[ -x "$PHP" ] || PHP=php

# Composer: telepitett parancs, vagy a helyi composer.phar
if command -v composer >/dev/null 2>&1; then
    COMPOSER="$PHP $(command -v composer)"
elif [ -f composer.phar ]; then
    COMPOSER="$PHP composer.phar"
else
    echo "Nincs composer! Toltsd le: curl -sS https://getcomposer.org/installer | $PHP" >&2
    exit 1
fi

echo "==> Karbantartas mod be"
$PHP artisan down || true

# Ha barmi hiba tortenik, az oldal ne maradjon karbantartas modban
trap '$PHP artisan up' EXIT

echo "==> Valtozasok letoltese (git pull)"
git pull

echo "==> Fuggosegek telepitese"
$COMPOSER install --no-dev --optimize-autoloader --no-interaction

echo "==> Adatbazis migracio"
$PHP artisan migrate --force

echo "==> Gyorsitotarak frissitese"
$PHP artisan optimize:clear
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

echo "==> Kesz! (az oldal ujra elerheto)"
