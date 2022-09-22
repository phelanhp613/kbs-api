<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BusinessClientService;

class BusinessClientController extends ApiController
{
    protected $businessClientService;

    public function __construct(BusinessClientService $businessClientService) {
        $this->businessClientService = $businessClientService;
    }

    public function list(Request $request)
    {
        return $this->response($this->businessClientService->list($request));
    }

    public function create(Request $request)
    {
        return $this->response($this->businessClientService->create($request));
    }

    public function update($id, Request $request)
    {
        return $this->response($this->businessClientService->update($id, $request));
    }

    public function delete($id)
    {
        return $this->response($this->businessClientService->delete($id));
    }
}
