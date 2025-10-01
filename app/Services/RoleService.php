<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all()
    {
        return $this->roleRepository->all();
    }

    public function find($id)
    {
        return $this->roleRepository->find($id);
    }

    /**
     * Create a new role and attach permissions
     */
    public function create(array $data)
    {
        $role = $this->roleRepository->create([
            'name' => $data['name'],
            'guard_name' => $data['guard_name']
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']); // Attach permissions
        }

        return $role->load('permissions'); // Load permissions relationship
    }

    /**
     * Update role and sync permissions
     */
    public function update($id, array $data)
    {
        $role = $this->roleRepository->update($id, [
            'name' => $data['name'] ?? null,
            'guard_name' => $data['guard_name'] ?? null
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']); 
        }

        return $role->load('permissions');
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function getAllPermission()
    {
        return $this->roleRepository->getAllPermission();
    }
}