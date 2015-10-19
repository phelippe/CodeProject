<?php

namespace CodeProject\Providers;

use CodeProject\Entities\ProjectTask;
use CodeProject\Events\TaskWasIncluded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        #tentativa frustrada de adicionar o owner como member
        /*Project::saved(function($project){
            dd($project);
        });*/

        ProjectTask::created(function($task){
            //event();
            Event::fire(new TaskWasIncluded($task));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
