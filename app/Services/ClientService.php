<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/2015
 * Time: 11:13
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{

    /**
     * @var ClientRepository
     */
    protected $repository;
    /**
     * @var ClientValidator
     */
    private $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator){
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function show($id){
        try {
            $rtrn = $this->repository->find($id);
            #dd($rtrn);
            return  $rtrn;
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
            #dd($data, $id);
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
                'message' => 'Usuario que está tentando atualizar não existe',
            ];
        }
    }

    public function destroy($id){
        try {
            $this->repository->delete($id);
            #acento aqui funcionou normal
            return "Usuário {$id} deletado com sucesso";
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Usuario que está tentando deletar não existe',
            ];
        }
    }
}