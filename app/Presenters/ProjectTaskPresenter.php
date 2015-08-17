<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectTaskPresenterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectTaskPresenterPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectTaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTaskTransformer();
    }
}
