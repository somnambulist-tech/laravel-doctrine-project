#!/usr/bin/env bash

echo "Building caches"
rm storage/cache/hydrators/*
rm storage/cache/proxies/*
composer dumpautoload
./artisan optimize
./artisan doctrine:generate:proxies
./artisan doctrine:generate:hydrators
./artisan config:cache
./artisan route:cache
./artisan twig:clean
