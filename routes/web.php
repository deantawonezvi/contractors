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

Route::any('/tender/details', 'TenderController@viewTenderDetails');
Route::any('/bid/approve', 'TenderController@approveTender');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tender/add', 'HomeController@index')->name('add_tender');


Route::resource('/tenders', 'TenderController');
