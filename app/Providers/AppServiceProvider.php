<?php

namespace CodeProject\Providers;

use CodeProject\Entities\ProjectTask;
use CodeProject\Events\TaskWasConcluded;
use CodeProject\Events\TaskWasIncluded;
use CodeProject\Events\TaskWasUpdated;
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
        ProjectTask::updated(function($task){
            //event();
            if($task->status == 2){
                Event::fire(new TaskWasConcluded($task));
            } else {
                Event::fire(new TaskWasUpdated($task));
            }
            //if($tas)

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
