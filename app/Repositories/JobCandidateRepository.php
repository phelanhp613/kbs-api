<?php

namespace App\Repositories;

use App\Models\JobCandidate;

class JobCandidateRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new JobCandidate();
    }
}
