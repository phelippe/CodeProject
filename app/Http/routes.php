<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::put('client/{id}', 'ClientController@update');
Route::delete('client/{id}', 'ClientController@destroy');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::put('project/{id}', 'ProjectController@update');
Route::delete('project/{id}', 'ProjectController@destroy');

Route::get('project/note', 'ProjectNoteController@index');
Route::post('project/note', 'ProjectNoteController@store');
Route::get('project/note/{id}', 'ProjectNoteController@show');
Route::put('project/note/{id}', 'ProjectNoteController@update');
Route::delete('project/note/{id}', 'ProjectNoteController@destroy');

Route::get('project/{id}/tasks', 'ProjectTaskController@index');
Route::post('project/{id}/tasks', 'ProjectTaskController@store');
Route::get('project/tasks/{id}', 'ProjectTaskController@show');
Route::put('project/tasks/{id}', 'ProjectTaskController@update');
Route::delete('project/tasks/{id}', 'ProjectTaskController@destroy');

Route::get('project/{id}/members', 'ProjectMemberController@index'); #?