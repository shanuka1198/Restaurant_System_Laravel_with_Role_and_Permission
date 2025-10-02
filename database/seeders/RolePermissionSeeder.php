<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $permissions = [
            'customers_view',
            'customers_create',
            'customers_update',
            'customers_delete',

            'item_categories_view',
            'item_categories_create',
            'item_categories_update',
            'item_categories_delete',

            'item_view',
            'item_create',
            'item_update',
            'item_delete',

            'order_view',
            'order_create',
            'order_create',
            'order_delete',

            'role_view',
            'role_create',
            'role_update',
            'role_delete',

            'user_view',
            'user_create',
            'user_update',
            'user_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo([
            'item_view',
            'order_view',
            'order_create',
            'order_update',
            'order_delete',
            'item_categories_view',
        ]);

        $Admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => bcrypt('admin123')]
        );

        $User = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'User', 'password' => bcrypt('user123')]
        );

        $Admin->assignRole($adminRole);
        $User->assignRole($userRole);


    }
}