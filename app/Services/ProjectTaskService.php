<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
{


    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskService
     */
    private $validator;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function show($id){
        try {
            #hidden não funciona
            return $this->repository->hidden(['project_id'])->find($id);
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Tarefa não existe',
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
                'message' => 'A tarefa que está tentando atualizar não existe',
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
                'message' => 'A tarefa que está tentando deletar não existe',
            ];
        }
    }
}