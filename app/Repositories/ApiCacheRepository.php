<?php

namespace App\Repositories;

use App\Models\ApiCache;

class ApiCacheRepository extends BaseRepository
{
    protected $expiresIn = "7 day";
    protected $version = "20170317";

    public function __construct()
    {
        $this->model = new ApiCache();
    }

    public function get($key)
    {
        $rec = $this->detailBy('cache_key', $key);
        if (empty($rec)) {
            return null;
        }
        // if cache version is old renew cache
        if ($rec->updated_at < date("Y-m-d h:i:s", strtotime($this->version))) {
            $rec->delete();
            return null;
        }
        return $rec;
    }

    function getCache($key, $expiresIn = null)
    {
        $rec = $this->get($key);
        if (empty($rec)) {
            return null;
        }
        $r = $rec->content;
        if (empty($r)) {
            return null;
        }
        if (is_array($r)) {
            if ($rec->updated_at < date("Y-m-d h:i:s", $this->getExpiresIn($expiresIn))) {
                return null;
            }
        } else {
            $updatedAt = $r->updated_at();
            if (! $updatedAt) {
                return $rec->updated_at < date("Y-m-d h:i:s", $this->getExpiresIn()) ? null : $r;
            }
            $updatedAt = date("Y/m/d h:i:s", $updatedAt);
            if ($updatedAt < date("Y/m/d h:i:s", strtotime('-1 month'))) {
                if ($rec->updated_at < date("Y-m-d h:i:s", strtotime("-5 days"))) {
                    return null;
                }
            } elseif ($updatedAt < date("Y/m/d h:i:s", strtotime('-2 weeks'))) {
                if ($rec->updated_at < date("Y-m-d h:i:s", strtotime("-3 days"))) {
                    return null;
                }
            }
        }
        return $r;
    }

    function set($key, $content)
    {
        $rec = $this->get($key);
        $attributes = ['content' => $content];
        if (empty($rec)) {
            $attributes['cache_key'] = $key;
            $this->create($attributes);
        } else {
            $attributes['updated_at'] = date("Y-m-d h:i:s");
            $rec->update($attributes);
        }
    }

    protected function getExpiresIn($expiresIn = null)
    {
        if (! $expiresIn) {
            $expiresIn = $this->expiresIn;
        }
        return strtotime("-" . $expiresIn);
    }
}

