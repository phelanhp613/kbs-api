<?php

namespace App\PortersObject;

use App\Services\PortersCategoryService;
use App\Repositories\CategoryRepository;

class PortersCategoryObject extends PortersOptionObject
{
    public $khrCategory;

    function __construct($xml)
    {
        $this->categoryRepository = new CategoryRepository();
        $this->json = json_decode(json_encode($xml));
        $field = 'Option.P_Id';
        $id = (string) $this->json->$field;
        $khrCategoryIds = PortersCategoryService::$jobCategoriesTable[$id - 10000] ?? null;
        if ($khrCategoryIds) {
            $this->khrCategory = $this->categoryRepository->get($khrCategoryIds);
        }
    }

    function url()
    {
        return "/category/{$this->id()}";
    }
}
