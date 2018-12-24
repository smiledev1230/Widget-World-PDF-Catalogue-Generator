<?php

use Illuminate\Http\Request;

Route::post('login', 'UserController@login');
Route::post('logout', 'UserController@logout');
Route::get('getUser','UserController@getUser');
Route::get('getNotification', 'NotificationsController@getNotification');
Route::get('getSupplier', 'SupplierController@getSupplier');
Route::get('getCategory', 'CategoryController@getCategory');
Route::get('getRecentCatalogue', 'CatalogueController@getRecentCatalogue');
Route::get('getDownloadPDF', 'CatalogueController@getDownloadPDF');

Route::post('update', 'UserController@update');
Route::post('register', 'UserController@register');
Route::post('/uploadToS3', 'CatalogueController@uploadToS3');
Route::post('/saveSelectProduct', 'CatalogueController@saveSelectProduct');
Route::post('savePDF', 'CatalogueController@savePDF');
Route::post('duplicateCatalogue', 'CatalogueController@duplicateCatalogue');
Route::post('deleteCatalogue', 'CatalogueController@deleteCatalogue');
Route::post('sendPDF', 'CatalogueController@sendPDF');
Route::post('updateNotificationView', 'NotificationsController@updateNotificationView');
Route::post('updateNotificationDelete', 'NotificationsController@updateNotificationDelete');

Route::group(['middleware' => 'auth:api'], function(){
});
