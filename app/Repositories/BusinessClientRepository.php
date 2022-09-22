<?php

namespace App\Repositories;

use App\Models\BusinessClient;

class BusinessClientRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new BusinessClient();
    }
}
