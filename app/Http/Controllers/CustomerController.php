<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\CustomerServices;
use App\Helper\ResponseHelper;

class CustomerController extends Controller
{
    /**
     * Customer service instance
     */
    protected CustomerServices $customerServices;

    /**
     * Constructor
     */
    public function __construct(CustomerServices $customerServices)
    {
        $this->customerServices = $customerServices;

        // Authentication middleware
        $this->middleware('auth:sanctum');

        // Permissions middleware
        $this->middleware('permission:customers_view')->only(['index', 'show']);
        $this->middleware('permission:customers_create')->only(['store']);
        $this->middleware('permission:customers_update')->only(['update']);
        $this->middleware('permission:customers_delete')->only(['destroy']); 
    }

    /**
     * List all customers
     */
    public function index()
    {
        try {
            $customers = $this->customerServices->all();
            return ResponseHelper::success('Customers retrieved successfully', $customers);
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Failed to load customers: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a new customer
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $customer = $this->customerServices->create($request->validated());
            return ResponseHelper::success('Customer created successfully', $customer, 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Customer creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show a specific customer
     */
    public function show($id)
    {
        try {
            $customer = $this->customerServices->find($id);
            if (!$customer) {
                return ResponseHelper::error('error', 'Customer not found', 404);
            }
            return ResponseHelper::success('Customer retrieved successfully', $customer);
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve customer: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update a specific customer
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $customer = $this->customerServices->update($id, $request->validated());
            return ResponseHelper::success('Customer updated successfully', $customer);
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Customer update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a specific customer
     */
    public function destroy($id)
    {
        try {
            $this->customerServices->delete($id);
            return ResponseHelper::success('Customer deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('error', 'Customer deletion failed: ' . $e->getMessage(), 500);
        }
    }
}