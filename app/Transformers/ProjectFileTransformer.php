<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFilePresenter;

/**
 * Class ProjectFilePresenterTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectFilePresenterTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectFilePresenter entity
     * @param \ProjectFilePresenter $model
     *
     * @return array
     */
    public function transform(ProjectFilePresenter $model) {
        return [
            'id'         => (int)$model->id,
            'description' => $model->description,
            'extension' => $model->extension,
            'project_id' => $model->project_id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}