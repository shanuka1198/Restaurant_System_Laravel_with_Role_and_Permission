<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Helper\ResponseHelper;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Exception;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        
         $this->middleware('auth:sanctum');

        // Permissions middleware
        $this->middleware('permission:item_view')->only(['index', 'show']);
        $this->middleware('permission:item_create')->only(['store']);
        $this->middleware('permission:item_update')->only(['update']);
        $this->middleware('permission:item_delete')->only(['destroy']); 
        
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of all items.
     */
    public function index()
    {
        try {
            $items = $this->itemService->all();
            return ResponseHelper::success('success', 'Items retrieved successfully', $items);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve items: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created item.
     */
    public function store(StoreItemRequest $request)
    {
        try {
            $item = $this->itemService->create($request->validated());
            if (!$item) {
                return ResponseHelper::error('error', 'Item creation failed');
            }
            return ResponseHelper::success('success', 'Item created successfully', $item);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Item creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified item.
     */
    public function show($id)
    {
        try {
            $item = $this->itemService->find($id);
            return ResponseHelper::success('success', 'Item retrieved successfully', $item);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Item not found: ' . $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified item.
     */
    public function update(UpdateItemRequest $request, $id)
    {
        try {
            $updatedItem = $this->itemService->update($id, $request->validated());
            return ResponseHelper::success('success', 'Item updated successfully', $updatedItem);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Item update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->itemService->delete($id);
            if ($deleted) {
                return ResponseHelper::success('success', 'Item deleted successfully');
            }
            return ResponseHelper::error('error', 'Item deletion failed');
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Item deletion failed: ' . $e->getMessage(), 500);
        }
    }
}