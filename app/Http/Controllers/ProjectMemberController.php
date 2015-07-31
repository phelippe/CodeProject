<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Services\ProjectMemberService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberService
     */
    private $service;
    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    /**
     * @param ProjectMemberService $service
     * @param ProjectMemberRepository $repository
     */
    public function __construct(ProjectMemberService $service, ProjectMemberRepository $repository){

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
        return $this->repository->with(['user'])->findByField('project_id', $id_project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    /*public function store(Request $request)
    {
        return $this->service->create($request->all());
    }*/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    /*public function show($id)
    {
        return $this->service->show($id);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    /*public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    /*public function destroy($id)
    {
        return $this->service->destroy($id);
    }*/
}
