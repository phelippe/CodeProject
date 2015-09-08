<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectNoteController extends Controller
{
    /**
     * @var ProjectNoteService
     */
    private $service;
    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * @param ProjectNoteService $service
     * @param ProjectNoteRepository $repository
     */
    public function __construct(ProjectNoteService $service, ProjectNoteRepository $repository)
    {

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
        return $this->repository->skipPresenter()->findWhere(['project_id' => $id_project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($project_id, Request $request)
    {
        return $this->service->create($project_id, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($project_id, $note_id)
    {
        return $this->service->show($project_id, $note_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $project_id, $note_id)
    {
        return $this->service->update($request->all(), $project_id, $note_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($project_id, $note_id)
    {
        return $this->service->destroy($note_id);
    }
}
