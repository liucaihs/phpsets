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

Route::get('/','AccountController@index')->middleware('chklogin');
Route::get('/index','AccountController@index')->middleware('chklogin');
//    function () {
//    return view('welcome');
//
//});


/*
 * 后台路由
 */
Route::get('login','LoginController@login');
Route::post('login','LoginController@loginPost');
Route::get('logout','LoginController@logout');
Route::get('403','LoginController@noPrimsion');


Route::get('account','AccountController@index')->middleware('chklogin'); //账号列表
Route::get('account/add','AccountController@addView')->middleware('chklogin'); //账号添加 界面
Route::post('account/add','AccountController@store')->middleware('chklogin'); //账号添加 入库
Route::get('account/del/{id}','AccountController@del')->middleware('chklogin'); //账号删除
Route::match(['get','post'],'account/up/{id}','AccountController@update')->middleware('chklogin'); //账号编辑

//Permission
Route::get('permission','PermissionController@index')->middleware('chklogin'); //权限列表
Route::get('permission/add','PermissionController@addView')->middleware('chklogin'); //权限添加 界面
Route::post('permission/add','PermissionController@store')->middleware('chklogin'); //权限添加 入库
Route::get('permission/del/{id}','PermissionController@del')->middleware('chklogin'); //权限删除
Route::match(['get','post'],'permission/up/{id}','PermissionController@update')->middleware('chklogin'); //权限编辑

//Role
Route::get('role','RoleController@index')->middleware('chklogin'); //角色列表
Route::get('role/add','RoleController@addView')->middleware('chklogin'); //角色添加 界面
Route::get('role/perm/{id}','RoleController@permissions')->middleware('chklogin'); //角色权限
Route::post('role/perm/{id}','RoleController@permissions')->middleware('chklogin'); //角色权限
Route::post('role/add','RoleController@store')->middleware('chklogin'); //角色添加 入库
Route::get('role/del/{id}','RoleController@del')->middleware('chklogin'); //角色删除
Route::match(['get','post'],'role/up/{id}','RoleController@update')->middleware('chklogin'); //角色编辑


Route::group(['middleware' => 'chklogin'], function () {
    Route::get('setting', 'SettingController@index');
    Route::post('setting/save', 'SettingController@saveInsert');
    Route::get('setting/del/{id}', 'SettingController@del');

    Route::get('channel', 'ChannelController@index');
    Route::post('channel/save', 'ChannelController@saveInsert');
    Route::get('channel/del/{id}', 'ChannelController@del');
    Route::post('channel/rate', 'ChannelController@saveRate');

    Route::get('channel/chansel', 'ChannelController@chanselect');
    Route::get('channel/appsel/{name?}', 'ChannelController@appidselect');

    //订单查看
    Route::get('orders', 'OrdersController@index');

    Route::get('passage', 'PassagewayController@index');
    Route::post('passage/save', 'PassagewayController@saveInsert');
    Route::get('passage/del/{id}', 'PassagewayController@del');
    Route::get('passage/passsel', 'PassagewayController@passselect');

    Route::get('billing', 'BillingtypeController@index');
    Route::post('billing/save', 'BillingtypeController@saveInsert');
    Route::get('billing/del/{id}', 'BillingtypeController@del');

    //统计部分
    Route::get('passto', 'PasstotalController@index');
    //统计部分
    Route::get('passtoall', 'PasstotalController@indexAll');
    //统计部分
    Route::get('chanto', 'ChantotalController@index');

    //业务委派
    Route::get('appids', 'AccountappController@index');
    Route::post('appids/save', 'AccountappController@update');


});

