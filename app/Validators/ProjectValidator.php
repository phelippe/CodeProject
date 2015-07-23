<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/2015
 * Time: 11:22
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{


    protected $rules = [
        'owner_id' => 'required',
        'client_id' => 'required',
        'name' => 'required|max:255',
        'description' => 'required',
        'progress' => 'required',
        'status' => 'required',
        'due_date' => 'required',
    ];

}