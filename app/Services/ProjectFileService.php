<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/15
 * Time: 20:23
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectFileRepository;
use Illuminate\Filesystem\Filesystem;
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
                                #ProjectFileValidator $validator,
                                Filesystem $filesystem,
                                Storage $storage){
        $this->repository = $repository;
        #$this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data){
        try {
            #dd($this->filesystem->get($data['file']));
            $file = $this->repository->create($data);
            #dd($file['data']['id']);
            #$file = new \stdClass();
            #$file->id = 1;
            $this->storage->put( $file['data']['id'].'.'.$data['extension'], $this->filesystem->get($data['file']) );
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
            $file = $this->repository->find($file_id);

            return $this->storage->get($file_id.'.'.$file->extension);
        } catch(ModelNotFoundException $e){
            return [
                'error' => true,
                'message' => 'Nota não existe',
            ];
        }
    }


    public function destroy($project_id, $file_id){
        try {
            $file = $this->repository->find($file_id);

            $this->repository->delete($file->id);
            $this->storage->delete( $file->id.'.'.$file->extension );
        } catch(ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag(),
            ];
        }
    }
}