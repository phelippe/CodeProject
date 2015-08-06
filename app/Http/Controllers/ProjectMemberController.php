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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store($project_id, Request $request)
    {
        return $this->service->create($project_id, $request->all());
    }

}
