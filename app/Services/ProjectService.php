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
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\CountValidator\Exception;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{


    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $validator;
    /**
     * @var ProjectMemberRepository
     */
    private $project_member_repository;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     * @param ProjectMemberRepository $project_member_repository
     * @internal param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $project_member_repository){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project_member_repository = $project_member_repository;
    }

    public function show($id){
        try {
            //hidden nao funciona
            return $this->repository->hidden(['owner_id', 'client_id'])->with(['owner', 'client', 'notes'])->find($id);
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Projeto não existe',
            ];
        }
    }

    public function listMembers($id_project){
        try {
            return $this->repository->with(['members'])->find($id_project);
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Projeto não existe',
            ];
        }
    }

    public function create(array $data){
        // enviar email
        // disparar notificacao
        // postar tweet
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id){
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'O Projeto que está tentando atualizar não existe',
            ];
        }
    }

    public function destroy($id){
        try {
            $this->repository->delete($id);
            #acento aqui funcionou normal
            return "Projeto id:{$id} deletado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'O Projeto que está tentando deletar não existe',
            ];
        }
    }

    public function addMember(array $data){
        try{
            /*$this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);*/

            #$this->repository->create();
        } catch(Exception $e){
            return 'erro:'.$e;
        }
    }

    public function removeMember($id_user, $id_project){
        try{

        } catch(Exception $e){
            return 'erro:'.$e;
        }
    }

    public function isMember($id_user, $id_project){
        return 'isMember';
    }
}