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

class ProjectTaskValidator extends LaravelValidator
{

    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'project_id' => 'required|integer',
            'name' => 'required',
            #'start_date' => 'required',
            #'due_date' => 'required',
            'status' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE=> [
            'project_id' => 'required|integer',
            'name' => 'required',
            #'start_date' => 'required',
            #'due_date' => 'required',
            'status' => 'required',
        ],
    ];

}