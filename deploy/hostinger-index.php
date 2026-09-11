<?php

// Copy to /home/u528935801/domains/lesbambinos.sn/public_html/app/index.php.
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__, 2).'/mere-teresa';
if (file_exists($maintenance = $base.'/storage/framework/maintenance.php')) {
    require $maintenance;
}
require $base.'/vendor/autoload.php';
/** @var Application $app */
$app = require_once $base.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);
$app->handleRequest(Request::capture());
