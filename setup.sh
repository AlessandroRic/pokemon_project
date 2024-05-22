#!/bin/bash

# Create or update the .env file with APP_ENV and APP_SECRET
{
  echo "APP_ENV=dev"
  echo "APP_SECRET=$(openssl rand -base64 32)"
  echo 'DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"'
  echo 'MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0'
} >> .env

echo ".env file has been updated with APP_ENV=dev and a new APP_SECRET"

{
  echo "KERNEL_CLASS='App\Kernel'"
  echo "APP_SECRET='$ecretf0rt3st'"
  echo "SYMFONY_DEPRECATIONS_HELPER=999999"
  echo "PANTHER_APP_ENV=panther"
  echo "PANTHER_ERROR_SCREENSHOT_DIR=./var/error-screenshots"
} >> .env.test

echo ".env.test file has been created"

# Run composer install inside the Docker container
composer install

