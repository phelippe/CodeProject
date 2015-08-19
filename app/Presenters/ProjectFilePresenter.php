<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectFilePresenterTransformer;
use CodeProject\Transformers\ProjectFileTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectFilePresenterPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectFilePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectFileTransformer();
    }
}
