<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 08/08/2015
 * Time: 23:26
 */

namespace CodeProject\Presenters;


use CodeProject\Transformers\ProjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTransformer();
    }
}