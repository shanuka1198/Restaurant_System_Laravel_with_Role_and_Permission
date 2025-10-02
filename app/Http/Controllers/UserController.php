<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Helper\ResponseHelper;
use Illuminate\Routing\Controller;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:sanctum');

        // Permission middleware
        $this->middleware('permission:user_view')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['store']);
        $this->middleware('permission:user_update')->only(['update']);
        $this->middleware('permission:user_delete')->only(['destroy']);

        $this->userService = $userService;
    }

    /**
     * List all users
     */
    public function index()
    {
        try {

            $users = $this->userService->getUsers(request());
            return ResponseHelper::success('success', 'Users retrieved successfully', $users);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve users: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a new user
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return ResponseHelper::success('success', 'User created successfully', $user);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'User creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show a single user
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUser($id);
            if (!$user) {
                return ResponseHelper::error('error', 'User not found', 404);
            }
            return ResponseHelper::success('success', 'User retrieved successfully', $user);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve user: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update a user
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return ResponseHelper::success('success', 'User updated successfully', $user);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'User update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a user
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->userService->deleteUser($id);
            if ($deleted) {
                return ResponseHelper::success('success', 'User deleted successfully');
            }
            return ResponseHelper::error('error', 'User deletion failed');
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'User deletion failed: ' . $e->getMessage(), 500);
        }
    }
}
