<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {

    // Authenticated User Routes
    Route::controller(AuthController::class)->group(function () {
        Route::get('user', 'userProfile');
        Route::get('logout', 'logout');
    });

    // Customer Routes
    Route::controller(CustomerController::class)->group(function () {
        Route::get('customers', 'index');
        Route::post('customers', 'store');
        Route::get('customers/{id}', 'show');
        Route::put('customers/{id}', 'update');
        Route::delete('customers/{id}', 'destroy');
    });

    // Item Category Routes
    Route::controller(ItemCategoryController::class)->group(function () {
        Route::get('item-categories', 'index');
        Route::post('item-categories', 'store');
        Route::get('item-categories/{id}', 'show');
        Route::put('item-categories/{id}', 'update');
        Route::delete('item-categories/{id}', 'destroy');
    });

    // Item Routes
    Route::controller(ItemController::class)->group(function(){
        Route::get('items', 'index');           // List all items
        Route::post('items', 'store');          // Create new item
        Route::get('items/{id}', 'show');       // Show single item
        Route::put('items/{id}', 'update');     // Update item
        Route::delete('items/{id}', 'destroy'); // Delete item
    });

    Route::controller(OrderController::class)->group(function()
    {
        Route::get('order', 'index');
        Route::post('order', 'store');
        Route::get('order/{id}', 'show');
        Route::put('order/{id}', 'update');
        Route::delete('order/{id}', 'destroy');
    });
});