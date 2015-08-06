<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectMemberValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectMemberService
{


    /**
     * @var ProjectMemberRepository
     */
    private $repository;
    /**
     * @var ProjectMemberService
     */
    private $validator;
    /**
     * @var ProjectRepository
     */
    private $user_repository;

    /**
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberValidator $validator
     * @param ProjectRepository $project_repository
     * @internal param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator, ProjectRepository $project_repository){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project_repository = $project_repository;
    }

    public function index($id_project){
        return $this->project_repository->find($id_project)->members()->get();
    }

    public function create($project_id, array $data){
        try {
            $data['project_id'] = $project_id;
            #dd($data);
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

}