<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectNotePresenterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectNotePresenterPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectNotePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectNoteTransformer();
    }
}
