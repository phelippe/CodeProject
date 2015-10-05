<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Filesystem\Filesystem;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectFileService
{


    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskService
     */
    private $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param ProjectFileRepository|ProjectTaskRepository $repository
     * @param ProjectFileValidator $validator
     * @param Filesystem $filesystem
     * @param Storage $storage
     * @internal param ProjectTaskService $service
     */
    public function __construct(ProjectFileRepository $repository,
                                ProjectFileValidator $validator,
                                Filesystem $filesystem,
                                Storage $storage){
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data){
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #dd($this->filesystem->get($data['file']));

            $file = $this->repository->create($data);

            #dd($file['data']['id']);
            #$file = new \stdClass();
            #$file->id = 1;
            #$this->storage->put( $file['data']['id'].'.'.$data['extension'], $this->filesystem->get($data['file']) );

            $this->storage->put( $file->getFileName(), $this->filesystem->get($data['file']) );
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function update(array $data, $id_project, $id_file){
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $file = $this->repository->update($data, $id_file);

            return $file;
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    #@TODO
    public function show($file_id){
        try {

            $projectFile = $this->repository->skipPresenter()->find($file_id);
            return $this->getBaseURL($projectFile);

            /*$file = $this->repository->find($file_id);

            return $this->storage->get($file_id.'.'.$file->extension);*/
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Nota não existe',
            ];
        }
    }

    private function getBaseURL($projectFile){
        switch ($this->storage->getDefaultDriver()){
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix()
                    .'/'.$projectFile->getFileName();
        }
    }


    public function destroy($project_id, $file_id){
        try {
            $file = $this->repository->find($file_id);

            $this->repository->delete($file->id);
            #$this->storage->delete( $file->id.'.'.$file->extension );
            $this->storage->delete( $file->getFileName() );
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }

    public function getFileName($id_file){
        $file = $this->repository->skipPresenter()->find($id_file);
        return $file->getFileName();
    }
}