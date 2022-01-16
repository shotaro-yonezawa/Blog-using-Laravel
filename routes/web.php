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

// プロダクト一覧画面を表示
Route::get('/product', 'ProductController@showList')->name('products');
// プロダクト登録画面を表示
Route::get('/product/create', 'ProductController@showCreate')->name('create');
// プロダクト登録
Route::post('/product/store', 'ProductController@exeStore')->name('store');
// プロダクト詳細画面を表示
Route::get('/product/{id}', 'ProductController@showDetail')->name('show');
// プロダクト編集画面を表示
Route::get('/product/edit/{id}', 'ProductController@showEdit')->name('edit');
// プロダクト編集
Route::post('/product/update', 'ProductController@exeUpdate')->name('update');
// プロダクト削除
Route::post('/product/delete/{id}', 'ProductController@exeDelete')->name('productDelete');

// 認証機能
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

// プロダクト検索
Route::post('/search', 'HomeController@index')->name('search');