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
    $projects = DB::table('projects')->get();

    return view('welcome', compact('projects'));

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('projects', 'ProjectsController');


Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');
Route::post('/tasks/{task}/comments', 'TaskCommentController@store');
