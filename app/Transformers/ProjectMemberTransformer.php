<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 08/08/2015
 * Time: 23:24
 */

namespace CodeProject\Transformers;


use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
    /*public function transform(User $user){
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }*/
    protected $defaultIncludes = ['user'];

    public function transform(ProjectMember $member){
        return [
            'member_id' => $member->id,
            'project_id' => $member->project_id,
        ];
    }

    public function includeUser(ProjectMember $member){
        return $this->item($member->member, new MemberTransformer());
    }
}