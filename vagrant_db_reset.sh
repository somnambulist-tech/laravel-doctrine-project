#!/usr/bin/env bash

echo "Resetting DB to defaults - do NOT run in production..."
./artisan doctrine:schema:drop --force
./artisan doctrine:migrations:reset
./artisan doctrine:migrations:migrate
./artisan db:seed
echo "Done"
