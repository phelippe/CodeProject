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
        #dd($request->project, $file);
        $extension = $file->getClientOriginalExtension();

        $data['project_id'] = $request->project;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['extension'] = $extension;
        $data['file'] = $file;

        #dd($data);
        $this->service->create($data);
    }

    public function update(Request $request, $project_id, $file_id)
    {
        return $this->service->update($request->all(), $project_id, $file_id);
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
        #return $this->service->show($file_id);
        if( $this->service->checkProjectPermissions($project_id) == false ){
            return ['error' => 'Acesso negado'];
        }
        return response()->download($this->service->show($file_id));
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
