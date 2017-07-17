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

Route::get('/', 'Controller@welcome');
Route::any('/tender/search', 'Controller@search');

Route::get('/tender/details', 'TenderController@viewTenderDetails');
Route::any('/tender/job/details', 'TenderController@viewJobDetails');
Route::any('/tender/job/delete', 'TenderController@removeBidTender');
Route::any('/tender/job/decline', 'TenderController@declineJobDetails');
Route::any('/bid/approve', 'TenderController@approveTender');
Route::any('/bid/submit/view', 'TenderController@viewBidTender');
Route::post('/bid/submit', 'TenderController@submitBidTender');
Route::post('/purchase_order/submit', 'PurchaseOrderController@uploadPurchaseOrder');
Route::get('/purchase_order/delete', 'PurchaseOrderController@deletePurchaseOrder');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tender/add', 'HomeController@index')->name('add_tender');


Route::resource('/tenders', 'TenderController');
