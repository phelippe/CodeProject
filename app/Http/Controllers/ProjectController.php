<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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

        $this->middleware('CheckProjectOwner', ['only' => ['update', 'destroy']]);
        $this->middleware('CheckProjectPermissions', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        #return $this->repository->hidden(['owner_id', 'client_id'])->with(['owner', 'client'])->all();
        /*return $this->repository->
            with(['client', 'tasks', 'notes', 'members'])->
            all()->members()->where(['user_id' => Authorizer::getResourceOwnerId()]);*/
        return $this->service->index();
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
        return $this->service->show($id);
    }

    public function listMembers($id)
    {
        return $this->service->listMembers($id);
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
        return $this->service->destroy($id);
    }
}
