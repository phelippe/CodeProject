<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskService
     */
    private $service;
    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @param ProjectTaskService $service
     * @param ProjectTaskRepository $repository
     */
    public function __construct(ProjectTaskService $service, ProjectTaskRepository $repository){

        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id_project)
    {
        return $this->repository->hidden(['project_id'])->findByField('project_id', $id_project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $project_id)
    {
        return $this->service->create($request->all(),$project_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($project_id, $task_id)
    {
        return $this->service->show($project_id, $task_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $project_id, $task_id)
    {
        return $this->service->update($request->all(), $project_id, $task_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($project_id, $task_id)
    {
        return $this->service->destroy($project_id, $task_id);
    }

    public function lastTasks(){
        #dd($this->repository->paginate(6));
        return $this->repository->paginate(6);
    }
}
