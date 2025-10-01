<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Routing\Controller;
use Exception;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth:sanctum');

        // Permissions middleware
        $this->middleware('permission:role_view')->only(['index', 'show', 'getAllPermission']);
        $this->middleware('permission:role_create')->only(['store']);
        $this->middleware('permission:role_update')->only(['update']);
        $this->middleware('permission:role_delete')->only(['destroy']); 

        $this->roleService = $roleService;
    }

    /**
     * Display a listing of all roles.
     */
    public function index()
    {
        try {
            $roles = $this->roleService->all();
            return ResponseHelper::success('success', 'Roles retrieved successfully', $roles);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve roles: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created role.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->create($request->validated());
            return ResponseHelper::success('success', 'Role created successfully', $role);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Role creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        try {
            $role = $this->roleService->find($id);
            return ResponseHelper::success('success', 'Role retrieved successfully', $role);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Role not found: ' . $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified role.
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            $role = $this->roleService->update($id, $request->validated());
            return ResponseHelper::success('success', 'Role updated successfully', $role);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Role update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->roleService->delete($id);
            if ($deleted) {
                return ResponseHelper::success('success', 'Role deleted successfully');
            }
            return ResponseHelper::error('error', 'Role deletion failed');
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Role deletion failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get all permissions
     */
    public function getAllPermission()
    {
        try {
            $permissions = $this->roleService->getAllPermission();
            return ResponseHelper::success('success', 'Permissions retrieved successfully', $permissions);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve permissions: ' . $e->getMessage(), 500);
        }
    }
}