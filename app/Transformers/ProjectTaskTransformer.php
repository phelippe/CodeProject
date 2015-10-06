<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

/**
 * Class ProjectTaskPresenterTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectTaskTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectTaskPresenter entity
     * @param \ProjectTaskPresenter $model
     *
     * @return array
     */
    public function transform(ProjectTask $model) {
        return [
            'id'         => (int)$model->id,
            'project_id' => (int)$model->project_id,

            'name' => $model->name,
            'status' => $model->status,

            'start_date' => $model->start_date,
            'due_date' => $model->due_date,

            /* place your other model properties here */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}