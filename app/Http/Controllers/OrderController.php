<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Helper\ResponseHelper;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
      $this->middleware('auth:sanctum');

        // Permissions middleware
        $this->middleware('permission:order_view')->only(['index', 'show']);
        $this->middleware('permission:order_create')->only(['store']);
        $this->middleware('permission:order_update')->only(['update']);
        $this->middleware('permission:order_delete')->only(['destroy']);    
        $this->orderService = $orderService;
    }

    /**
     * List all orders
     */
    public function index()
    {
        try {
            $orders = $this->orderService->all();
            return ResponseHelper::success('success', 'Orders retrieved successfully', $orders);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve orders: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show a specific order
     */
    public function show($id)
    {
        try {
            $order = $this->orderService->find($id);
            return ResponseHelper::success('success', 'Order retrieved successfully', $order);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Order not found: ' . $e->getMessage(), 404);
        }
    }

    /**
     * Store a new order
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->create($request->validated());
            return ResponseHelper::success('success', 'Order created successfully', $order);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Order creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update an existing order
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        try {
            $order = $this->orderService->update($id, $request->validated());
            return ResponseHelper::success('success', 'Order updated successfully', $order);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Order update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete an order
     */
    public function destroy($id)
    {
        try {
            $this->orderService->delete($id);
            return ResponseHelper::success('success', 'Order deleted successfully');
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Order deletion failed: ' . $e->getMessage(), 500);
        }
    }
}