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
| Additional routes form CG\Forms include /forms/edit/{id}
|
*/

Route::get('/', function () { // Default landing page
    return view('welcome');
});

Route::get('/base', function() { // Views the base form in use
    return CG\Forms\BaseForm::first();
});
Route::get('/create', 'RequestController@create'); // Creates fresh filled form
Route::get('/view/{id}', 'RequestController@view'); // Views a filled form
Route::get('/delete/{id}', 'RequestController@delete'); // Deletes a filled form
