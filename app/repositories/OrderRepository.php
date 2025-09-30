<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderInterface;


class OrderRepository extends BaseRepository implements OrderInterface
{
    public function __construct(Order $model)
    {
         parent::__construct($model);
    }
}