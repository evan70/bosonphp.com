<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    new Dotenv()->bootEnv(dirname(__DIR__) . '/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

//
// Do not forget to execute
// $ php bin/console --env=test doctrine:database:create
// $ php bin/console --env=test doctrine:migrations:migrate --no-interaction
//
