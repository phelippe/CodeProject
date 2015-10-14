<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFilePresenter;

/**
 * Class ProjectFilePresenterTransformer
 * @package namespace CodeProject\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['projects'];

    /**
     * Transform the \ProjectFilePresenter entity
     * @param \ProjectFilePresenter $model
     *
     * @return array
     */
    public function transform(Client $model) {
        return [
            'id'         => (int)$model->id,
            'name' => $model->name,
            'responsible' => $model->responsible,
            'email' => $model->email,
            'phone' => $model->phone,
            'address' => $model->address,
            'obs' => $model->obs,

            /* place your other model properties here */
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeProjects(Client $client)
    {
        //return $this->collection($client->projects, new MemberTransformer());
        //ou como abaixo

        $transformer = new ProjectTransformer();
        $transformer->setDefaultIncludes([]);
        return $this->collection($client->projects, $transformer);
    }
}