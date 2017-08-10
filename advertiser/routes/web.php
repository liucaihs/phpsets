<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','AdvertiserController@index')->middleware('chklogin');
Route::get('login','LoginController@login');
Route::post('login','LoginController@loginPost');
Route::get('logout','LoginController@logout');
Route::get('login/account','LoginController@acconut_id')->middleware('chklogin');

Route::get('index','AdvertiserController@index')->middleware('chklogin'); //广告主列表
Route::get('index/pulldown','AdvertiserController@pulldown')->middleware('chklogin'); //广告主列表

Route::get('index/operate','OperateController@index')->middleware('chklogin'); //广告数据列表

Route::get('index/information','InformationController@index')->middleware('chklogin'); //账户信息
