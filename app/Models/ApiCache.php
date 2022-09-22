<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCache extends Model
{
    protected $table = 'api_caches';

    protected $fillable = [
        'id',
        'cache_key',
        'content',
        'inserted_at',
        'updated_at'
    ];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = serialize($value);
    }

    public function getContentAttribute($value)
    {
        return unserialize($value);
    }
}
