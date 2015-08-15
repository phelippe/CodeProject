<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectFileController extends Controller
{
    protected $service;

    public function __construct(ProjectFileService $service){
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['description'] = $request->name;
        $data['project_id'] = $request->project;

        $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($project_id, $file_id)
    {
        #dd($project_id, $file_id);
        return $this->service->show($file_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($project_id, $file_id)
    {
        return $this->service->destroy($project_id, $file_id);
    }
}
