<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});
/*
 * 接口路由
 */
$app->post('upload/{name}/{md5}',[  'uses' => 'IndexController@uploadRecv' ]);
$app->get('download/{name}',[  'uses' => 'IndexController@downFile' ]);
$app->get('isExist/{name}',[  'uses' => 'IndexController@fileExist' ]);
