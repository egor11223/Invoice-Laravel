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
    return view('index');
});
Route::get('items', 'Item\ItemController@listItems');
Route::resource('item', 'Item\ItemController');
Route::post('invoice/line-items', 'Invoice\InvoiceController@storeLineItems');
Route::resource('invoice', 'Invoice\InvoiceController');
Route::get('customerByID/{id}', 'Customer\CustomerController@getCustomer');
Route::resource('customer', 'Customer\CustomerController');
