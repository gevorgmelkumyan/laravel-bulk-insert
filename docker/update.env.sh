#!/bin/bash

APP_ENV_FILE="../.env"
DOCKER_ENV_FILE=".env"

if [ ! -f "$DOCKER_ENV_FILE" ]; then
    echo "docker/.env is missing, copying from docker/.env.example..."
    cp .env.example .env
fi

if [ ! -f "$APP_ENV_FILE" ]; then
    echo "application .env is missing, copying from .env.example..."
    cp ../.env.example ../.env

    # Load environment variables from .env to this script's session
    set -a
    [ -f .env ] && . ./.env
    [ -f ../.env ] && . ../.env
    set +a

    if [ -z "$APP_URL" ]; then
        APP_URL="http://localhost:$SERVER_PORT"
    fi

    # Export all the necessary variables fetched from both .envs to the core .env
    {
        printf "\n"
        echo "APP_URL=$APP_URL"
        printf "\n"
        echo "DB_CONNECTION=pgsql"
        echo "DB_HOST=lbi_postgres"
        echo "DB_PORT=5432"
        echo "DB_DATABASE=$DB_DATABASE"
        echo "DB_USERNAME=$DB_USERNAME"
        echo "DB_PASSWORD=$DB_PASSWORD"
        printf "\n"
        echo "REDIS_HOST=lbi_redis"
        echo "REDIS_PORT=6379"
    } >> ../.env
fi
