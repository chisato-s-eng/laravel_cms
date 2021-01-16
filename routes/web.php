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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// カテゴリ一覧ページ
Route::get('/home', 'HomeController@index')->name('home');
// 商品一覧ページ
Route::get('/item_list', 'HomeController@ShowItemList');
// 購入履歴ページ
Route::get('/history', 'HomeController@ShowHistoryList')->name('history');
// 購入明細ページ
Route::get('/history/{id}/detail', 'HomeController@ShowHistoryDetail')->name('history.detail');

Route::prefix('cart')->name('cart')->group(function() {
    // カート一覧ページ
    Route::get('/', 'CartController@ShowCartList');
    // カートへの追加処理
    Route::post('/add', 'CartController@AddCart')->name('.add');
    // カートの購入予定数変更処理
    Route::post('/update_amount', 'CartController@UpdateAmount')->name('.update_amount');
    // カートの商品削除処理
    Route::post('/delete', 'CartController@DeleteItem')->name('.delete');
    // 購入処理
    Route::post('/purchase', 'CartController@Purchase')->name('.purchase');
});

Route::prefix('admin')->name('admin.')->group(function() {
    // home
    Route::get('/home', 'Admin\HomeController@index')->name('home');
    // ログインフォーム
    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    // ログイン処理
    Route::post('/login', 'Admin\Auth\LoginController@login');
    // ログアウト処理
    Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');
    // 登録フォーム
    Route::get('/register', 'Admin\Auth\RegisterController@showRegisterForm')->name('input');
    // 登録処理
    Route::post('/register', 'Admin\Auth\RegisterController@register')->name('register');
    
    // 商品追加処理
    Route::post('/add_item', 'ItemController@AddItem')->name('add_item');
    // 在庫数変更処理
    Route::post('/update_stock', 'ItemController@UpdateStock')->name('update_stock');
    // ステータス変更処理
    Route::post('/update_status', 'ItemController@UpdateStatus')->name('update_status');
    // 商品削除処理
    Route::post('/delete_item', 'ItemController@DeleteItem')->name('delete_item');
    
    // 購入履歴一覧
    Route::get('/history', 'Admin\HomeController@ShowHistoryList')->name('history');
    // 購入明細ページ
    Route::get('/history/{id}/detail', 'Admin\HomeController@ShowHistoryDetail')->name('history.detail');
});
