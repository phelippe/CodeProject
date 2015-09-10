<?php

namespace CodeProject\Providers;

use CodeProject\Entities\Project;
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
