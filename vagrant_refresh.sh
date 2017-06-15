#!/usr/bin/env bash

echo "Refreshing App..."
mkdir -p storage/cache/hydrators storage/cache/twig storage/cache/proxies storage/tmp
composer update --no-scripts
rm storage/cache/hydrators/*
rm storage/cache/proxies/*
composer dumpautoload

echo "Clearing caches..."
./artisan debugbar:clear
./artisan config:clear
./artisan route:clear
./artisan view:clear
./artisan twig:clean
./artisan clear-compiled
./artisan doctrine:clear:metadata:cache
./artisan doctrine:clear:query:cache
./artisan doctrine:clear:result:cache

echo "Re-generating cache files..."
./artisan doctrine:generate:proxies
./artisan doctrine:generate:hydrators

echo "Running migrations..."
./artisan doctrine:migrations:migrate
./artisan ide-helper:generate
./artisan ide-helper:meta

echo "Updating npm / gulp..."
npm install
npm prune
gulp
