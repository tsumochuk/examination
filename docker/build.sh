#!/bin/bash

docker compose down && docker compose -f docker-compose.yml up -d --build