<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController; 
use Illuminate\Support\Facades\Route;

// Public Routes (Auth)
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Protected Routes (Sanctum + Auth)
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
    Route::controller(ItemController::class)->group(function() {
        Route::get('items', 'index');
        Route::post('items', 'store');
        Route::get('items/{id}', 'show');
        Route::put('items/{id}', 'update');
        Route::delete('items/{id}', 'destroy');
    });

    // Order Routes
    Route::controller(OrderController::class)->group(function() {
        Route::get('orders', 'index');
        Route::post('orders', 'store');
        Route::get('orders/{id}', 'show');
        Route::put('orders/{id}', 'update');
        Route::delete('orders/{id}', 'destroy');
    });

    // Role Routes
    Route::controller(RoleController::class)->group(function() {
        Route::get('roles', 'index');          
        Route::post('roles', 'store');         
        Route::get('roles/{id}', 'show');      
        Route::put('roles/{id}', 'update');    
        Route::delete('roles/{id}', 'destroy');

        // Permissions (handled by RoleController)
        Route::get('permissions', 'getAllPermission'); 
    });

});