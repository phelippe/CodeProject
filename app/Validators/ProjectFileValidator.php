<?php
/**
 * Created by PhpStorm.
 * User: phelippe
 * Date: 22/07/2015
 * Time: 11:22
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{


    protected $rules = [
        'project_id' => 'required',
        'nome' => 'required',
        'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip',
        'description' => 'required',
    ];

}