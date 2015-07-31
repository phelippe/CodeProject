<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMemberRepository;
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
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /*public function show($id){
        try {
            return $this->repository->hidden(['project_id'])->with(['project'])->find($id);
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Usuario não existe',
            ];
        }
    }

    public function create(array $data){
        // enviar email
        // disparar notificacao
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
                'message' => 'Não foi possível atualizar',
            ];
        }
    }

    public function destroy($id){
        try {
            $this->repository->delete($id);
            #acento aqui funcionou normal
            return "Nota id:{$id} deletado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'O usuário que está tentando desvincular não existe',
            ];
        }
    }*/
}