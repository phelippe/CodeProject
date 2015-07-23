<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    private $service;
    /**
     * @var ProjectRepository
     */
    private $repository;

    /**
     * @param ProjectService $service
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectService $service, ProjectRepository $repository){

        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        #hidden não está funcionando
        return $this->repository->hidden(['owner_id', 'client_id'])->with(['owner', 'client'])->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            return $this->repository->find($id);
            return 'deletado com sucesso';
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Usuario não encontrado',
            ];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
        /*try {
            $this->repository->delete($id);
            return 'deletado com sucesso';
        } catch(Excepti $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }*/
    }
}
