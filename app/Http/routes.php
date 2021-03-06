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
    return view('app');
});

Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('teste', function(){
    #return \CodeProject\Entities\Project::find(10)->members()->where(['user_id'=>11])->first();
    /*return \CodeProject\Entities\Project::with(['members' => function($query){
        $query->where(['user_id'=>4]);
    }])->orWhere(['owner_id' => 1])->get();*/
    /*return \CodeProject\Entities\Project::with(['members'=>function($query){
        $query->where(['user_id'=>1]);
    }])->get();*/
    #return \CodeProject\Entities\User::find(1)->projects()->with(['client', 'tasks', 'notes', 'members'])->where(['project_id'=>8])->get();
    #return \CodeProject\Entities\Project::find(3)->members()->where(['user_id'=>1])->first();
});

Route::group(['middleware'=>'oauth'], function(){


	//Rotas isoladas devem vir antes dos resources!
    Route::get('user/authenticated', 'UserController@authenticated');

    #@TODO: listagem de usuarios para recuperar na listagem de owners no cad. de projeto
    Route::resource('user', 'UserController', ['except'=>['create', 'edit']] );
    Route::resource('client', 'ClientController', ['except'=>['create', 'edit']] );

    #Route::group(['middleware'=>'check.project.permissions'], function(){

        Route::get('project/list-as-member', 'ProjectController@indexAsMember');

        Route::get('project/tasks', 'ProjectTaskController@lastTasks');
        Route::resource('project', 'ProjectController', ['except'=>['create', 'edit']] );

        Route::resource('project.notes', 'ProjectNoteController', ['except'=>['create', 'edit']] );
        Route::resource('project.tasks', 'ProjectTaskController', ['except'=>['create', 'edit']] );
        Route::resource('project.members', 'ProjectMemberController', ['except'=>['create', 'edit', 'update']] );
        Route::get('project/{id}/is_member/{id_user}', 'ProjectMemberController@isMember');
        #route::post('project/{id}/file', 'ProjectFileController@store');
        Route::resource('project.file', 'ProjectFileController', ['only'=>['index', 'show', 'store', 'update', 'destroy']]);
        Route::get('project/{project}/file/{file}/download', 'ProjectFileController@download');
    #});

    /*Route::resource('project.notes', 'ProjectNoteController', ['except'=>['create', 'edit']] );
    Route::resource('project.tasks', 'ProjectTaskController', ['except'=>['create', 'edit']] );
    Route::resource('project.members', 'ProjectMemberController', ['except'=>['create', 'edit']] );
    Route::get('project/{id}/is_member/{id_user}', 'ProjectMemberController@isMember');
    #route::post('project/{id}/file', 'ProjectFileController@store');
    Route::resource('project.file', 'ProjectFileController', ['only'=>['index', 'show', 'store', 'update', 'destroy']]);
    Route::get('project/{project}/file/{file}/download', 'ProjectFileController@download');*/



});
