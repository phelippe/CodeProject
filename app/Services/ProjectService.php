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
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Filesystem\Filesystem;
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
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     * @param ProjectMemberRepository $project_member_repository
     * @param UserRepository $user_repository
     * @param Filesystem $filesystem
     * @param Storage $storage
     * @internal param ProjectService $service
     */
    public function __construct(ProjectRepository $repository,
                                ProjectValidator $validator,
                                ProjectMemberRepository $project_member_repository,
                                UserRepository $user_repository,
                                Filesystem $filesystem,
                                Storage $storage){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->project_member_repository = $project_member_repository;
        $this->user_repository = $user_repository;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function index()
    {
        #return $this->user_repository->find(Authorizer::getResourceOwnerId())->projects()->with(['client', 'tasks', 'notes', 'members'])->get();
        return $this->user_repository->find(Authorizer::getResourceOwnerId())->projects()->get();
    }

    public function show($id){
        try {
            //hidden nao funciona
            return $this->repository->hidden(['owner_id', 'client_id'])->with(['owner', 'client', 'notes', 'members'])->find($id);
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

            //Adiciona o owner como membro
            $this->project_member_repository->create(['project_id'=>$project->id, 'user_id' => $project->owner_id]);

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

    public function createFile(array $data){
        #dd($data);
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        #dd($project);
        $projectFile = $project->files()->create($data);

        $this->storage->put( $projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']) );

    }


}