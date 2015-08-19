<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFilePresenter;

/**
 * Class ProjectFilePresenterTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectFilePresenter entity
     * @param \ProjectFilePresenter $model
     *
     * @return array
     */
    public function transform(ProjectFile $model) {
        return [
            'id'         => (int)$model->id,
            'name'         => (int)$model->name,
            'description' => $model->description,
            'extension' => $model->extension,
            'project_id' => $model->project_id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}