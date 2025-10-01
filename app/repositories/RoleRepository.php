<?php

namespace App\Repositories;
use App\Repositories\Interfaces\RoleInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository extends BaseRepository implements RoleInterface
{
      public function __construct(Role $model)
    {
         parent::__construct($model);
    }

    public function getAllPermission()
    {
        return Permission::all();
    }

}
