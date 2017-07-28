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

Route::get('/','AdvertiserController@index')->middleware('chklogin');
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

Route::get('index','AdvertiserController@index')->middleware('chklogin'); //广告主列表
Route::get('index/add','AdvertiserController@addindex')->middleware('chklogin'); //广告主添加
Route::post('index/add','AdvertiserController@store')->middleware('chklogin'); //广告主添加 入库
Route::get('index/delete/{id}','AdvertiserController@delete')->middleware('chklogin'); //广告主删除
Route::post('index/update','AdvertiserController@update')->middleware('chklogin'); //广告主修改

Route::get('advertising','AdvertisingController@index')->middleware('chklogin'); //广告列表
Route::get('advertising/add','AdvertisingController@add')->middleware('chklogin'); //广告添加
Route::get('advertising/pulldown','AdvertisingController@pulldown'); //->middleware('chklogin')广告主下拉
Route::post('advertising/add','AdvertisingController@store')->middleware('chklogin'); //广告添加 入库
Route::get('advertising/delete/{id}','AdvertisingController@delete')->middleware('chklogin'); //广告删除
Route::post('advertising/update','AdvertisingController@update')->middleware('chklogin'); //广告修改
Route::get('advertising/select','AdvertisingController@advselect'); //->middleware('chklogin')广告下拉选择数据

Route::get('channel','ChannelController@index')->middleware('chklogin'); //渠道列表
Route::get('channel/add','ChannelController@addChannel')->middleware('chklogin'); //渠道添加 界面
Route::post('channel/add','ChannelController@store')->middleware('chklogin'); //渠道添加 入库
Route::get('channel/del/{id}','ChannelController@del')->middleware('chklogin'); //渠道删除
Route::match(['get','post'],'channel/up/{id}','ChannelController@update')->middleware('chklogin'); //渠道编辑
Route::get('channel/select','ChannelController@chlselect'); //->middleware('chklogin')渠道下拉选择数据

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

//puton
Route::get('adputon','AdvputonController@index')->middleware('chklogin'); //广告投放列表
Route::get('adputon/add','AdvputonController@addView')->middleware('chklogin'); //广告投放添加 界面
Route::post('adputon/add','AdvputonController@store')->middleware('chklogin'); //广告投放添加 入库
Route::get('adputon/del/{id}','AdvputonController@del')->middleware('chklogin'); //广告投放删除
Route::match(['get','post'],'adputon/up/{id}','AdvputonController@update')->middleware('chklogin'); //广告投放编辑
Route::get('adputon/stop/{id}','AdvputonController@stopAct')->middleware('chklogin'); //广告投放暂停
Route::match(['get','post'],'adputon/copy/{id}','AdvputonController@copyAct')->middleware('chklogin'); //广告投放复制
Route::get('adputon/select','AdvputonController@putselect'); //->middleware('chklogin')广告投放下拉选择数据

//CMDB
Route::get('cmdb','CMDBController@index')->middleware('chklogin'); //配置管理列表
Route::get('cmdb/add','CMDBController@addView')->middleware('chklogin'); //配置管理添加 界面
Route::post('cmdb/add','CMDBController@store')->middleware('chklogin'); //配置管理添加 入库
Route::get('cmdb/del/{id}','CMDBController@del')->middleware('chklogin'); //配置管理删除
Route::post('cmdb/update','CMDBController@update')->middleware('chklogin'); //配置管理编辑

//operate
Route::get('operate','OperateController@index')->middleware('chklogin'); //运营统计列表
Route::get('operate/total','OperateController@totalCreate')->middleware('chklogin'); //运营统计列表
Route::get('idfa','OperateController@ifaOne')->middleware('chklogin'); //运营统计列表
Route::get('recvidfa','OperateController@recvIfaActivate')->middleware('chklogin'); //运营统计列表
Route::get('mvclick','OperateController@moveHistoryClick'); //运营统计列表

Route::get('advertisers_test','Advertisers_testController@index')->middleware('chklogin'); //广告主测试 界面

Route::post('testurl','Advertisers_testController@getTest')->middleware('chklogin'); //广告主测试 界面
