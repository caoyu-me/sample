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

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
 //注册
Route::get('signup','UsersController@create')->name('signup');
//接受注册数据
Route::resource('users','UsersController');
//会话控制
//显示
Route::get('login','SessionsController@create')->name('login');
//登录
Route::post('login','SessionsController@store')->name('login');
//注销
Route::delete('logout','SessionsController@destroy')->name('logout');