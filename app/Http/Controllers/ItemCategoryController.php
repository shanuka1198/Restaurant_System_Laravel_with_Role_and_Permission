<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Helper\ResponseHelper;
use App\Models\ItemCategory;
use App\Http\Requests\StoreItemCategoryRequest;
use App\Http\Requests\UpdateItemCategoryRequest;
use App\Services\ItemCategoryService;
use Exception;

class ItemCategoryController extends Controller
{
    protected $itemCategoryService;

    public function __construct(ItemCategoryService $itemCategoryService)
    {
         $this->middleware('auth:sanctum');

        // Permissions middleware
        $this->middleware('permission:item_categories_view')->only(['index', 'show']);
        $this->middleware('permission:item_categories_create')->only(['store']);
        $this->middleware('permission:item_categories_update')->only(['update']);
        $this->middleware('permission:item_categories_delete')->only(['destroy']);
        
        $this->itemCategoryService = $itemCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = $this->itemCategoryService->all();
            return ResponseHelper::success('success', 'Categories retrieved successfully', $categories);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Failed to retrieve categories: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemCategoryRequest $request)
    {
        try {
            $itemCategory = $this->itemCategoryService->create($request->validated());
            if (!$itemCategory) {
                return ResponseHelper::error('error', 'Category creation failed');
            }
            return ResponseHelper::success('success', 'Category created successfully', $itemCategory);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Category creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = $this->itemCategoryService->find($id);
            return ResponseHelper::success('success', 'Category retrieved successfully', $category);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Category not found: ' . $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemCategoryRequest $request, $id)
    {
        try {
            $updatedCategory = $this->itemCategoryService->update($id, $request->validated());
            return ResponseHelper::success('success', 'Category updated successfully', $updatedCategory);
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Category update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->itemCategoryService->delete($id);
            if ($deleted) {
                return ResponseHelper::success('success', 'Category deleted successfully');
            }
            return ResponseHelper::error('error', 'Category deletion failed');
        } catch (Exception $e) {
            return ResponseHelper::error('error', 'Category deletion failed: ' . $e->getMessage(), 500);
        }
    }
}