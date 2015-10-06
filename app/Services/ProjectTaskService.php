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

    public function show($project_id, $task_id){
        try {
            $rtrn = $this->repository->findWhere(['project_id'=>$project_id, 'id'=>$task_id]);

            #dd($rtrn['data'][0]);
            #dd($rtrn);
            $rtrn = $rtrn['data'][0];

            return $rtrn;
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Tarefa não existe',
            ];
        }
    }

    public function create(array $data, $project_id){
        // enviar email
        // disparar notificacao
        try {
            $data['project_id'] = $project_id;
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $project_id, $task_id){
        try {
            $data['project_id'] = $project_id;
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $task_id);
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

    public function destroy($project_id, $task_id){
        try {
            $this->repository->delete($task_id);
            #acento aqui funcionou normal
            return "Nota id:{$task_id} deletado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'A tarefa que está tentando deletar não existe',
            ];
        }
    }
}