<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 08/08/2015
 * Time: 23:24
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
    //protected $defaultIncludes = ['members', 'notes', 'tasks', 'files', 'client', 'owner'];
    protected $avaliableIncludes = ['members', 'notes', 'tasks', 'files', 'client', 'owner'];

    public function transform(Project $project){
        return [
            'id' => $project->id,
            'project_id' => $project->id,
            'name' => $project->name,
            'owner_id' => $project->owner_id,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'client_id' => $project->client_id,
            'due_date' => $project->due_date,
            'is_member' => $project->owner_id != \Authorizer::getResourceOwnerId(),
            'tasks_count' => $project->tasks->count(),
            'tasks_opened' => $this->countTasksOpened($project),
        ];
    }


    public function includeOwner(Project $project)
    {
        return $this->item($project->owner, new UserTransformer());
    }

    public function includeClient(Project $project)
    {
        return $this->item($project->client, new ProjectClientTransformer());
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new MemberTransformer());
    }

    public function includeNotes(Project $project)
    {
        return $this->collection($project->notes, new ProjectNoteTransformer());
    }

    public function includeTasks(Project $project)
    {
        return $this->collection($project->tasks, new ProjectTaskTransformer());
    }

    public function includeFiles(Project $project)
    {
        return $this->collection($project->files, new ProjectFileTransformer());
    }

    public function countTasksOpened(Project $project)
    {
        $count = 0;
        foreach($project->tasks as $o){
            if($o->status == 1){
                $count++;
            }
        }
        return $count;
    }
}