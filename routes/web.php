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
    return view('home');
});

Route::get('/base', function() { // Views the base form in use
    return CG\Forms\BaseForm::all();
});
Route::get('/create', 'RequestController@create'); // Creates fresh filled form
Route::post('/new', 'RequestController@new');
Route::get('/index', 'RequestController@index'); // Views all filled forms
Route::get('/view/{id}', 'RequestController@view'); // Views a filled form
Route::get('/edit/{id}', 'RequestController@edit'); // Edits a filled form
Route::post('/edit/{id}', 'RequestController@editPOST');
Route::post('/delete', 'RequestController@deletePOST');
Route::get('/duplicate/{id}', 'RequestController@duplicate');
// View confirms details from old form and asks for new owner
// sends to edit like create as well (but with premade data)
Route::post('/export', 'RequestController@export');
// Send data through AJAX
