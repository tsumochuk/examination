#!/bin/bash

docker compose down && docker compose -f docker-compose.yml up -d --build --remove-orphans

sh ./docker/container-run-command.sh "composer install"