<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CustomerInterface;
use App\Repositories\Interfaces\ItemCategoryInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\Interfaces\OrderInterface;
use App\Repositories\Interfaces\RoleInterface;
use App\Repositories\Interfaces\UserInterface;

use App\Repositories\CustomerRepository;
use App\Repositories\ItemCategoryRepository;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(ItemCategoryInterface::class, ItemCategoryRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
         $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
