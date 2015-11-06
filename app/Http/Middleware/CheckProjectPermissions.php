<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;

class CheckProjectPermissions
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

        $rtrn = $this->repository->checkOwnershipAndMembership($user_id, $project_id);

        #dd($user_id, $project_id, $rtrn);
        if($rtrn){
            return $next($request);
        }
        //return ['error'=>'Access denied'];
        abort(403, 'Você não tem permissão para acessar este projeto');


        #inutilizado abaixo
        $project_id = $request->project;

        /*if( $this->repository->isMember($project_id,$user_id) == false){
            return ['error'=>'Access forbidden'];
        }*/
        if( count($this->repository->find($user_id)->projects()->where(['project_id'=>$project_id])->get()) == false ){
            return ['error'=>'Access forbidden'];
        }
        return $next($request);
    }
}
