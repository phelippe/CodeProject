<?php

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientTransformer;
use CodeProject\Transformers\ProjectFilePresenterTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectFilePresenterPresenter
 *
 * @package namespace CodeProject\Presenters;
 */
class ClientPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientTransformer();
    }
}
