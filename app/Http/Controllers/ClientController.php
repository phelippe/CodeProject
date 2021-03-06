<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var ClientService
     */
    private $service;

    /**
     * @param ClientRepository $repository
     * @param ClientService $service
     */
    public function __construct(ClientRepository $repository, ClientService $service){
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $limit = $request->query->get('limit', 15);
        $rtrn = $this->repository->paginate($limit);
        return $rtrn;
    }

    public function store(Request $request)
    {
        try {
            return $this->service->create($request->all());
        } catch(ValidatorException $e){
            return Response::json([
                'error' => true,
                'mensagens' => $e->getMessageBag(),
            ], 400);
        }
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
