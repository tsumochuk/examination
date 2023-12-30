#!/bin/bash

sh ./docker/container-run-command.sh "php bin/console app:check-currency-rate $1"