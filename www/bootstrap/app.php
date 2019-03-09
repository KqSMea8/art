<?php

/**
 * App
 */

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Just require the file in Laravel folder.
|
*/

$app = require LARAVEL_DIR . '/bootstrap/app.php';
// $app->configureMonologUsing(function($monolog) use($app) {
//     $monolog->pushHandler(new App\Utils\MysqlHandler());
// });
return $app;
