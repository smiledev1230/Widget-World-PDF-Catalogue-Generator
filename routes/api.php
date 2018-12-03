<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');
Route::get('getSupplier', 'SupplierController@getSupplier');
Route::get('getCategory', 'CategoryController@getCategory');
Route::get('getRecentCatalogue', 'CatalogueController@getRecentCatalogue');

Route::post('update', 'UserController@update');
Route::post('register', 'UserController@register');
Route::post('/uploadToS3', 'CatalogueController@uploadToS3');
Route::post('/saveSelectProduct', 'CatalogueController@saveSelectProduct');
Route::post('savePDF', 'GeneratePDFController@savePDF');
Route::post('duplicateCatalogue', 'CatalogueController@duplicateCatalogue');
Route::post('deleteCatalogue', 'CatalogueController@deleteCatalogue');
Route::post('sendPDF', 'CatalogueController@sendPDF');

Route::get('/products/{product}', 'ProductController@show');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users','UserController@index');
    Route::get('users/{user}','UserController@show');
    Route::patch('users/{user}','UserController@update');
    Route::get('users/{user}/orders','UserController@showOrders');
    Route::patch('products/{product}/units/add','ProductController@updateUnits');
    Route::resource('/products', 'ProductController')->except(['index','show']);
});
