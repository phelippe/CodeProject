<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectTaskPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\ProjectTask;

/**
 * Class ProjectTaskRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //Não dá pra usar 2 pushcriteria (esse + o de project)
        $this->pushCriteria( app('Prettus\Repository\Criteria\RequestCriteria') );
    }

    public function presenter(){
        return ProjectTaskPresenter::class;
    }
}