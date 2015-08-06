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
use CodeProject\Repositories\UserRepository;
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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberValidator $validator
     * @param ProjectRepository $project_repository
     * @param UserRepository $userRepository
     * @internal param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository,
                                ProjectMemberValidator $validator,
                                ProjectRepository $project_repository,
                                UserRepository $userRepository){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project_repository = $project_repository;
        $this->userRepository = $userRepository;
    }

    public function index($id_project){
        return $this->project_repository->find($id_project)->members()->withPivot("id")->get();
    }

    public function show($id_project, $id_member){
        try {
            return $this->repository->find($id_member)->user;
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Membro do projeto não existe',
            ];
        }
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

    public function destroy($id_member){
        try {
            $this->repository->delete($id_member);
            #acento aqui funcionou normal
            return "Membro desvinculado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'O membro que está tentando desvincular não existe',
            ];
        }
    }

    public function isMember($id_project, $id_user)
    {
        $is = $this->repository->findWhere([
            'project_id'=>$id_project,
            'user_id'=>$id_user,
        ]);

        if(count($is)>0){
            return 'true';
        }
        return 'false';
    }

}