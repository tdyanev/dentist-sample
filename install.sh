#!/bin/bash

composer install
npm install
npm run dev
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start -d