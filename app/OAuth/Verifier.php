<?php
/**
 * Created by PhpStorm.
 * User: Phelippe Matte
 * Date: 07/08/2015
 * Time: 23:43
 */

namespace CodeProject\OAuth;

use Illuminate\Support\Facades\Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}