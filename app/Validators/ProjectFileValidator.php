<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/2015
 * Time: 11:22
 */

namespace CodeProject\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{

    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'project_id' => 'required',
            'name' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip',
            'description' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE=> [
            'project_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ],
    ];

}