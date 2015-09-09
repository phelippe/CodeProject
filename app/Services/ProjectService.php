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
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
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
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     * @param ProjectMemberRepository $project_member_repository
     * @param UserRepository $user_repository
     * @internal param ProjectService $service
     */
    public function __construct(ProjectRepository $repository,
                                ProjectValidator $validator,
                                ProjectMemberRepository $project_member_repository,
                                UserRepository $user_repository){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project_member_repository = $project_member_repository;
        $this->user_repository = $user_repository;
    }

    public function index()
    {
        $rtrn = $this->user_repository->skipPresenter()->find(Authorizer::getResourceOwnerId())->projects()->with(['client', 'tasks', 'notes', 'members', 'owner'])->get();
        #return $this->user_repository->find(Authorizer::getResourceOwnerId())->projects()->with(['client', 'tasks', 'notes', 'members'])->get();
        #dd($rtrn);
        return $rtrn;
    }

    public function show($id){
        try {
            //hidden nao funciona
            $rtrn = $this->repository->skipPresenter()->hidden(['owner_id', 'client_id'])->with(['owner', 'client', 'notes', 'members', 'tasks'])->find($id);
            #dd($rtrn);
            return $rtrn;
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

            $project = $this->repository->create($data);

            $project_rtrn = $this->repository($project['id']);
            dd($project_rtrn);
            //Adiciona o owner como membro
            #$this->project_member_repository->create(['project_id'=>$project->id, 'user_id' => $project->owner_id]);
            $this->project_member_repository->create(['project_id'=>$project['data']['id'], 'user_id' => $project['data']['owner_id']]);

            return $project;
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

    #@TODO
    public function addMember(array $data){
        try{
            /*$this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);*/

            #$this->repository->create();
        } catch(Exception $e){
            return 'erro:'.$e;
        }
    }

    #@TODO
    public function removeMember($id_user, $id_project){
        try{

        } catch(Exception $e){
            return 'erro:'.$e;
        }
    }

    #@TODO
    public function isMember($id_user, $id_project){
        return 'isMember';
    }
}