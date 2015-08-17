<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectTaskPresenter;

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
    public function transform(ProjectTaskPresenter $model) {
        return [
            'id'         => (int)$model->id,
            'name' => $model->name,
            'project_id' => $model->project_id,
            'start_date' => $model->start_date,
            'due_date' => $model->due_date,
            'status' => $model->status,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}