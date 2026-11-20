<?php
// Copy only to public/demo/index.php for the separate Horizon installation.
use Illuminate\Http\Request;
define('LARAVEL_START',microtime(true));
// Recover old DirectorySlash redirects cached by browsers.
if (preg_match('#^/public/demo(?:/|$)#', $_SERVER['REQUEST_URI'] ?? '')) {
    header('Location: '.substr($_SERVER['REQUEST_URI'], 7), true, 302);
    exit;
}
$_SERVER['SCRIPT_NAME']='/demo/index.php';
$_SERVER['PHP_SELF']='/demo/index.php';
$demoRoot='/home/u528935801/domains/lesbambinos.sn/horizon-demo';
if(file_exists($maintenance=$demoRoot.'/storage/framework/maintenance.php')) require $maintenance;
require $demoRoot.'/vendor/autoload.php';
$app=require_once $demoRoot.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);
$app->handleRequest(Request::capture());
