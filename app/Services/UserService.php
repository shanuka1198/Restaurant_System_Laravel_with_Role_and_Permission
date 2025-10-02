<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users
     */
    public function getUsers()
    {
        return $this->userRepository->all();
    }

    /**
     * Get a single user by ID
     */
    public function getUser(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * Create a new user with roles & permissions
     */
    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $roles = $data['roles'] ?? [];
        $permissions = $data['permissions'] ?? [];

        unset($data['roles'], $data['permissions']);

        $user = $this->userRepository->create($data);

        $this->assignRolesAndPermissions($user, $roles, $permissions);

        return $user;
    }

    /**
     * Update user with roles & permissions
     */
    public function updateUser(int $id, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $roles = $data['roles'] ?? [];
        $permissions = $data['permissions'] ?? [];

        unset($data['roles'], $data['permissions']);

        $user = $this->userRepository->update($id, $data);

        $this->assignRolesAndPermissions($user, $roles, $permissions);

        return $user;
    }

    /**
     * Delete user
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Handle role & permission assignment
     */
    protected function assignRolesAndPermissions(User $user, array $roles, array $permissions): void
    {
        // Handle roles
        if (!empty($roles)) {
            $roleModels = Role::whereIn('id', $roles)
                              ->where('guard_name', 'web') // adjust to match your DB guard
                              ->get();

            if ($roleModels->count() !== count($roles)) {
                throw new \Exception('One or more roles are invalid.');
            }

            $user->syncRoles($roleModels);
        }

        // Handle permissions
        if (!empty($permissions)) {
            $permissionModels = Permission::whereIn('id', $permissions)
                                          ->where('guard_name', 'web') // adjust to match your DB guard
                                          ->get();

            if ($permissionModels->count() !== count($permissions)) {
                throw new \Exception('One or more permissions are invalid.');
            }

            $user->syncPermissions($permissionModels);
        }
    }
}
