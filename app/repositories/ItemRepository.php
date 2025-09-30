<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ItemInterface;
use App\Models\Item;


class ItemRepository extends BaseRepository implements ItemInterface
{
     public function __construct(Item $model)
    {
        parent::__construct($model);
    }
}