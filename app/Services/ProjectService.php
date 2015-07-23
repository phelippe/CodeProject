<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function show($id){
        try {
            return $this->repository->find($id);
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
}