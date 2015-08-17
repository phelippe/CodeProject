<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ProjectMemberPresenterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectMemberPresenterPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ProjectMemberPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectMemberTransformer();
    }
}
