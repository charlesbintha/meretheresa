<?php

use Illuminate\Http\Request;

// Silence PHP 8.5 deprecations fired while Laravel 11.51 parses vendor
// config/database.php (PDO::MYSQL_ATTR_SSL_CA). Remove once upstream
// switches to Pdo\Mysql::ATTR_SSL_CA.
error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
