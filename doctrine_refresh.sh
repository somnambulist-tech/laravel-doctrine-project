#!/usr/bin/env bash

echo "Refreshing Doctrine"
rm storage/cache/hydrators/*
rm storage/cache/proxies/*
composer dumpautoload
./artisan doctrine:clear:metadata:cache
./artisan doctrine:clear:query:cache
./artisan doctrine:clear:result:cache
./artisan doctrine:generate:proxies
./artisan doctrine:generate:hydrators
echo "Done"
