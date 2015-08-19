<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectNotePresenter;

/**
 * Class ProjectNotePresenterTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectNoteTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectNotePresenter entity
     * @param \ProjectNotePresenter $model
     *
     * @return array
     */
    public function transform(ProjectNote $model) {
        return [
            'id'         => (int)$model->id,
            'title' =>  $model->title,
            'note'  =>  $model->note,

            /* place your other model properties here */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}