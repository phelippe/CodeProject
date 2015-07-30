<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/2015
 * Time: 11:22
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{


    protected $rules = [
        'project_id' => 'required|integer',
        'user_id' => 'required|integer',
    ];

}