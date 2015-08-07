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

Route::get('project/{id}/members', 'ProjectMemberController@index');
/*Route::get('project/{id}/members', function(){
    $ret = '#';

    $ret = \CodeProject\Entities\;

    #dd($ret);
    return $ret;
});*/
Route::post('project/{id}/members', 'ProjectMemberController@store');
Route::get('project/{id}/members/{id_member}', 'ProjectMemberController@show');
Route::delete('project/{id}/members/{id_member}', 'ProjectMemberController@destroy');

Route::get('project/{id}/is_member/{id_user}', 'ProjectMemberController@isMember');

Route::get('project/{id}/notes', 'ProjectNoteController@index');
Route::post('project/{id}/notes', 'ProjectNoteController@store');
Route::get('project/{id}/notes/{id_note}', 'ProjectNoteController@show');
Route::put('project/{id}/notes/{id_note}', 'ProjectNoteController@update');
Route::delete('project/{id}/notes/{id_note}', 'ProjectNoteController@destroy');

Route::get('project/{id}/tasks', 'ProjectTaskController@index');
Route::post('project/{id}/tasks', 'ProjectTaskController@store');
Route::get('project/{id}/tasks/{id_task}', 'ProjectTaskController@show');
Route::put('project/{id}/tasks/{id_task}', 'ProjectTaskController@update');
Route::delete('project/{id}/tasks/{id_task}', 'ProjectTaskController@destroy');

