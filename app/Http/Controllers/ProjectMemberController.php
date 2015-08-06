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
        return $this->service->index($id_project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($project_id, $member_id)
    {
        #dd($member_id);
        return $this->service->show($project_id, $member_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($project_id, Request $request)
    {
        return $this->service->create($project_id, $request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id_project, $id_member)
    {
        return $this->service->destroy($id_member);
    }

    public function isMember($id_project, $id_user)
    {
        return $this->service->isMember($id_project, $id_user);
    }

}
