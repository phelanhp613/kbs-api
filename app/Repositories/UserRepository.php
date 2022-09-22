<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new User();
    }

    protected function hookFilterResultCustom($query, $filters)
    {
        if (!empty($filters['ids']) && is_array($filters['ids'])) {
            $query->whereIn('id', $filters['ids']);
        }
        if (!empty($filters['keyword'])) {
            $keyword = $filters['keyword'];
            $query = $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('email', 'LIKE', '%' . $keyword . '%');
            });
        }
        return $query;
    }

    public function getUserFromListId($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
