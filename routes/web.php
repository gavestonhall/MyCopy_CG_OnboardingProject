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

Route::get('/base', function() {
    return CG\Forms\BaseForm::all()->each->json_data;
});
Route::get('/create', 'testForm@create');
Route::get('/delete/{id}', 'testForm@delete');
