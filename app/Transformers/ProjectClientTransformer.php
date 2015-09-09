<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 08/08/2015
 * Time: 23:24
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\Client;
use League\Fractal\TransformerAbstract;

class ProjectClientTransformer extends TransformerAbstract
{
    public function transform(Client $client){
        return [
            #'id' => $user->id,
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'responsible' => $client->responsible,
            'phone' => $client->phone,
            'address' => $client->address,
            'obs' => $client->obs,
        ];
    }
}