<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobCandidateService;

class JobCandidateController extends ApiController
{
    protected $jobCandidateService;

    public function __construct(JobCandidateService $jobCandidateService) {
        $this->jobCandidateService = $jobCandidateService;
    }

    public function list(Request $request)
    {
        return $this->response($this->jobCandidateService->list($request));
    }

    public function create(Request $request)
    {
        return $this->response($this->jobCandidateService->create($request));
    }

    public function update($id, Request $request)
    {
        return $this->response($this->jobCandidateService->update($id, $request));
    }

    public function delete($id)
    {
        return $this->response($this->jobCandidateService->delete($id));
    }
}
