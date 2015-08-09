<?php

namespace CodeProject\Repositories;

use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Entities\Project;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }

    /*public function isOwner($id, $user_id)
    {
        if( count($this->findWhere(['id'=>$id, 'owner_id'=>$user_id])) ){
            return true;
        }
        return false;
    }

    public function isMember($id, $user_id)
    {
        #dd($this->find($id));
        if( count($this->find($id)->members()->where(['user_id'=>$user_id])->first()) ){
            return true;
        }
        return false;
    }*/

    public function presenter(){
        return ProjectPresenter::class;
    }
}