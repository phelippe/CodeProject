<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\UserRepository;
#use Illuminate\Http\Request;

use CodeProject\Http\Requests;
#use CodeProject\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{


    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function authenticated()
    {
        $userId = Authorizer::getResourceOwnerId();
        $rtrn = $this->repository->find($userId);

        return $rtrn;
    }

    public function index()
    {
        return $this->repository->all();
    }


    public function show()
    {
        //tem que ter esse método
    }

}
