<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ProjectFileController extends Controller
{
    protected $service;
    /**
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    private $storage;

    /**
     * @param ProjectFileService $service
     * @param ProjectFileRepository $repository
     */
    public function __construct(ProjectFileService $service, ProjectFileRepository $repository, Factory $storage){
        $this->service = $service;
        $this->repository = $repository;
        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id_project)
    {
        $rtrn = $this->repository->findWhere(['project_id' => $id_project]);
        #$rtrn = $this->repository->all();
        #dd($rtrn);

        return $rtrn;
    }

    /**
     * @param $id_project
     * @param $id_file
     * @return mixed
     */
    public function show($id_project, $id_file)
    {
        $rtrn = $this->repository->find($id_file);
        #$rtrn = $this->repository->all();
        #dd($rtrn);

        return $rtrn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $id_project)
    {
        $file = $request->file('file');
        #dd($request->project, $file);
        $extension = $file->getClientOriginalExtension();

        #$data['project_id'] = $request->project;
        $data['project_id'] = $id_project;
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
    /*public function show($project_id, $file_id)
    {
        #dd($project_id, $file_id);
        #return $this->service->show($file_id);
        if( $this->service->checkProjectPermissions($project_id) == false ){
            return ['error' => 'Acesso negado'];
        }
        return response()->download($this->service->show($file_id));
    }*/

    public function download($project_id, $file_id)
    {
        /*if( $this->service->checkProjectPermissions($project_id) == false ){
            return ['error' => 'Acesso negado'];
        }*/
        #return response()->download($this->service->show($file_id));

        $model = $this->repository->skipPresenter()->find($file_id);

        $file_path = $this->service->show($file_id);
        $file_content = file_get_contents($file_path);
        $file64 = base64_encode($file_content);
        return [
            'file' => $file64,
            'size' => filesize($file_path),
            'name' => $this->service->getFileName($file_id),
            'mime_type' => $this->storage->mimeType($this->service->getFileName($file_id)),
        ];
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
