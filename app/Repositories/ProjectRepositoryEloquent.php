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
        //$this->pushCriteria( app(RequestCriteria::class) );
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

    public function findOwner($user_id, $limit = null, $columns = array())
    {
        return $this->scopeQuery(function ($query) use ($user_id) {
            return $query->select('projects.*')->where('projects.owner_id', '=', $user_id);
        })->paginate($limit, $columns);
    }

    //paginate não funcionará ->erro de cardinalidade
    public function findWithOwnerAndMember($user_id)
    {
        return $this->scopeQuery(function ($query) use ($user_id) {
            return $query->select('projects.*')
                ->leftJoin('project_members', 'project_members.project_id', '=', 'projects.id')
                ->where('project_members.user_id', '=', $user_id)
                ->union($this->model->query()->getQuery()->where('owner_id', '=', $user_id));
        })->all();
    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }
}