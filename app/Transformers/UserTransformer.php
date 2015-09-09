<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 08/08/2015
 * Time: 23:24
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user){
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}