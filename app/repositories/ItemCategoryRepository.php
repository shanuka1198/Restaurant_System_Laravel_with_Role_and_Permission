<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ItemCategoryInterface;
use App\Models\ItemCategory;

class ItemCategoryRepository extends BaseRepository implements ItemCategoryInterface
{
    public function __construct(ItemCategory $model)
    {
        parent::__construct($model);
    }
}
