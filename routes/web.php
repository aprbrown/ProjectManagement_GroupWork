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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/projects', 'ProjectController@index');
Route::get('/projects/create', 'ProjectController@create');
Route::get('/projects/{project}', 'ProjectController@show');
Route::post('/projects', 'ProjectController@store');

Route::get('/tasks', 'TaskController@index');
Route::get('/tasks/create', 'TaskController@create');
Route::get('/projects/{project}/tasks/{task}', 'TaskController@show');
Route::delete('/projects/{project}/tasks/{task}', 'TaskController@destroy');
Route::post('/tasks', 'TaskController@store');

Route::get('/profiles/{user}', 'ProfilesController@show');

Route::post('/projects/{project}/tasks/{task}/comments', 'CommentController@store');
