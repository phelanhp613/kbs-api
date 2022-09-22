<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(Request $request)
    {
        return $this->response($this->userService->profile($request));
    }

    public function list(Request $request)
    {
        return $this->response($this->userService->list($request->all()));
    }

    public function create(Request $request)
    {
        return $this->response($this->userService->create($request->all()));
    }

    public function update($id, Request $request)
    {
        return $this->response($this->userService->update($id, $request->all()));
    }


    public function delete($id)
    {
        return $this->response($this->userService->delete($id));
    }
}
