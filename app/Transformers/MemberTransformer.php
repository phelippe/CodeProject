<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

/**
 * Class MemberTransformerTransformer
 * @package namespace CodeProject\Transformers;
 */
class MemberTransformer extends TransformerAbstract
{
    public function transform(User $member) {
        return [
            'user_id' => $member->id,
            'name' => $member->name,
        ];
    }
}