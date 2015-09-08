<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService
{


    /**
     * @var ProjectNoteRepository
     */
    private $repository;
    /**
     * @var ProjectNoteService
     */
    private $validator;

    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function show($project_id, $note_id){
        try {
            #$rtrn = $this->repository->skipPresenter()->findWhere(['project_id'=>$project_id, 'id'=>$note_id]);
            $rtrn = $this->repository->findWhere(['project_id'=>$project_id, 'id'=>$note_id])->first();
            #$rtrn = $this->repository->skipPresenter()->where()
            #dd($rtrn);
            return $rtrn;
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Nota não existe',
            ];
        }
    }

    public function create($project_id, array $data){
        // enviar email
        // disparar notificacao
        $data['project_id'] = $project_id;
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

    public function update(array $data, $project_id, $note_id){
        try {
            $data['project_id'] = $project_id;
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $note_id);
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'A nota que está tentando atualizar não existe',
            ];
        }
    }

    public function destroy($note_id){
        try {
            $this->repository->delete($note_id);
            #acento aqui funcionou normal
            return "Nota id:{$note_id} deletado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'A nota que está tentando deletar não existe',
            ];
        }
    }
}