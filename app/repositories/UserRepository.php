<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserInterface;
use App\Models\User;


class UserRepository extends BaseRepository implements UserInterface
{
        public function __construct(User $model)
    {
         parent::__construct($model);
    }
}
