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
Route::get('/index', function () {
    return view('index');
});

Route::get('/teste', 'PageController@index');

Route::get('/upload', 'UploadController@uploadForm');
Route::post('/upload', 'UploadController@uploadSubmit');

Route::get('/json', 'UploadController@listFile');
Route::get('/json/processing', 'UploadController@listProcessingFile');
Route::get('/json/processed', 'UploadController@listProcessedFile');

Route::get('/json/process/{id}', 'UploadController@processJson');
Route::get('/json/export/{filename}', 'UploadController@listExport');

Route::delete('/json/{id}', 'UploadController@deleteJson');