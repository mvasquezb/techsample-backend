#!/usr/bin/env bash

docker-compose up -d --build
docker-compose exec app bash -c "./artisan-commands.sh"