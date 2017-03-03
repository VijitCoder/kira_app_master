<?php
/**
 * Приложение по созданию нового приложения :)
 */
use kira\core\App;
use kira\web\Env;

mb_internal_encoding('UTF-8');

// Особое вычисление корневого каталога. KIRA_ROOT_PATH будет реальным корнем сайта, т.е. на каталог выше текущего.
$dir = rtrim(__DIR__, '/');
$dir = str_replace('\\', '/', $dir); // кроссплатформа
$dir = realpath($dir . '/..');
define('KIRA_ROOT_PATH', $dir . '/');
define('KIRA_APP_NAMESPACE', 'install\\');
define('KIRA_APP_PATH', KIRA_ROOT_PATH . 'install/');
define('KIRA_TEMP_PATH', KIRA_APP_PATH);
define('KIRA_VIEWS_PATH', KIRA_APP_PATH . 'views/');
define('KIRA_MAIN_CONFIG', KIRA_APP_PATH . 'app/config.php');

$composer = require KIRA_ROOT_PATH . 'vendor/autoload.php';
App::setComposer($composer);
unset($composer);

define('KIRA_DEBUG', !Env::isProduction());

ini_set('display_errors', (int)KIRA_DEBUG);
ini_set('display_startup_errors', (int)KIRA_DEBUG);
error_reporting(KIRA_DEBUG ? E_ALL : 0);

// для этого приложения - необязательно задавать часовой пояс. Но вообще это нужно.
//date_default_timezone_set(App::conf('timezone', false) ? : 'UTC');

App::router()->callAction();
