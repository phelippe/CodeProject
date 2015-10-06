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
    protected $defaultIncludes = ['members', 'notes', 'tasks', 'files', 'client'/*, 'owner'*/];

    public function transform(Project $project){
        return [
            'id' => $project->id,
            'project_id' => $project->id,
            'name' => $project->name,
            #'client_id' => $project->client_id,
            'owner_id' => $project->owner_id,
            'description' => $project->description,
            'progress' => (int) $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date,
            #'members' => $project->members,
        ];
    }


    /*public function includeOwner(Project $project)
    {
        return $this->collection($project->owner, new UserTransformer());
    }*/

    public function includeClient(Project $project)
    {
        return $this->item($project->client, new ProjectClientTransformer());
    }

    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer());
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
}