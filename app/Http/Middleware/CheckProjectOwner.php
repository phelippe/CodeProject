<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

class CheckProjectOwner
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository){

        $this->repository = $repository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = \Authorizer::getResourceOwnerId();
        $project_id = $request->project;

        /*if($this->repository->isOwner($project_id, $user_id) == false){
            return ['error'=>'Access forbidden'];
        }*/
        if( count($this->repository->findWhere(['id'=>$project_id, 'owner_id'=>$user_id])) == false){
            return ['error'=>'Access forbidden'];
        }
        return $next($request);
    }
}
