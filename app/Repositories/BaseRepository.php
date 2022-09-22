<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class BaseRepository
{
    protected $model;

    protected $cacheKeyDetail;

    /**
     * get detail a record
     * @param  integer $id
     * @return
     */
    public function detail($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function detailBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    public function getByMultiCondition(array $conditions)
    {
        return $this->model->where($conditions);
    }

    /**
     * Create resource
     */
    public function create($data)
    {
        $data['created_by'] = auth()->user()->id ?? null;
        $data['updated_by'] = auth()->user()->id ?? null;

        $result = $this->model->create($data);

        return $result ?? false;
    }

    /**
     * Create a new record if not exist, update if exist
     */
    public function updateOrCreate(array $attributes, array $values)
    {
        $result = $this->model->updateOrCreate($attributes, $values);

        return $result ?? false;
    }

    /**
     * Create manny
     * @param $bulkData
     * @return bool
     */
    public function bulkCreate(array $bulkData)
    {
        $result = $this->model->insert($bulkData);

        return $result ?? false;
    }

    /**
     * @return string
     */
    protected function getCacheKeyDetail($id)
    {
        $cacheKey = $this->cacheKeyDetail . $id;

        return $cacheKey;
    }

    /**
     * @param $id
     * @return mixed|null
     */
    protected function getCacheDetail($id)
    {
        if (!empty($this->cacheKeyDetail)) {
            $cacheKey = $this->getCacheKeyDetail($id);
            $detail = Cache::get($cacheKey);
            if (!empty($detail)) {
                return $detail;
            }
        }

        return null;
    }

    /**
     * @param $id
     */
    protected function clearCacheDetail($id)
    {
        if (!empty($this->cacheKeyDetail)) {
            $cacheKey = $this->getCacheKeyDetail($id);
            Cache::forget($cacheKey);
        }
    }

    /**
     * @param $id
     * @param $detail
     * @return mixed
     */
    protected function setCacheDetail($id, $detail)
    {
        if (!empty($this->cacheKeyDetail)) {
            $cacheKey = $this->getCacheKeyDetail($id);
            Cache::put($cacheKey, $detail, config('app-cache-keys.default_cache_time'));
        }

        return $detail;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function allBy($select = '*', $field, $value)
    {
        return $this->model->select($select)->where($field, $value)->get();
    }

    public function deleteById($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function updateById($id, $data)
    {
        $data['updated_by'] = auth()->user()->id ?? null;
        return $this->model->find($id)->update($data);
    }

    public function upsert($values, $uniqueBy, $update)
    {
        return $this->model->upsert($values, $uniqueBy, $update);
    }

    public function paginate($params)
    {
        $orderBy = 'created_at';
        $orderType = 'DESC';
        if (!empty($params['order_by'])) {
            $orderBy = $params['order_by'];
        }
        if (!empty($params['order_type'])) {
            $orderType = $params['order_type'];
        }
        $select = "*";
        if (!empty($params['fields']) && is_array($params['fields'])) {
            $select =  $params['fields'];
        }
        $query = $this->model->addSelect($select)->orderBy($orderBy, $orderType);
        if (!empty($params['filters'])) {
            $filters = is_array($params['filters']) ? $params['filters'] : (array)json_decode($params['filters']);
            $query = $this->hookFilterResultCustom($query, $filters);
        }
        $limit = !empty($params['limit']) ? $params['limit'] : config('zen-common.paginate_limit');
        $query = $this->hookPaginateWith($query);
        return $query->paginate($limit);
    }

    protected function hookFilterResultCustom($query, $filters)
    {
        return $query;
    }

    protected function hookPaginateWith($query)
    {
        return $query;
    }
}
