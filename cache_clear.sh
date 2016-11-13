#!/usr/bin/env bash

echo "Clearing caches"
rm storage/cache/hydrators/*
rm storage/cache/proxies/*
composer dumpautoload
./artisan doctrine:clear:metadata:cache
./artisan doctrine:clear:query:cache
./artisan doctrine:clear:result:cache
./artisan auth:clear-resets
./artisan config:clear
./artisan route:clear
./artisan view:clear
./artisan twig:clean
./artisan clear-compiled
