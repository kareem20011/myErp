<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FullAccessSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'view', 'group' => 'pos'],
            ['name' => 'view', 'group' => 'dashboard'],
            ['name' => 'view', 'group' => 'inventoryLogs'],
            ['name' => 'view', 'group' => 'LowStockNotification'],
            ['name' => 'view', 'group' => 'users'],
            ['name' => 'create', 'group' => 'users'],
            ['name' => 'update', 'group' => 'users'],
            ['name' => 'delete', 'group' => 'users'],
            ['name' => 'view', 'group' => 'roles'],
            ['name' => 'create', 'group' => 'roles'],
            ['name' => 'update', 'group' => 'roles'],
            ['name' => 'delete', 'group' => 'roles'],
            ['name' => 'view', 'group' => 'permissions'],
            ['name' => 'create', 'group' => 'permissions'],
            ['name' => 'update', 'group' => 'permissions'],
            ['name' => 'delete', 'group' => 'permissions'],
            ['name' => 'view', 'group' => 'suppliers'],
            ['name' => 'create', 'group' => 'suppliers'],
            ['name' => 'update', 'group' => 'suppliers'],
            ['name' => 'delete', 'group' => 'suppliers'],
            ['name' => 'view', 'group' => 'categories'],
            ['name' => 'create', 'group' => 'categories'],
            ['name' => 'update', 'group' => 'categories'],
            ['name' => 'delete', 'group' => 'categories'],
            ['name' => 'view', 'group' => 'subcategories'],
            ['name' => 'create', 'group' => 'subcategories'],
            ['name' => 'update', 'group' => 'subcategories'],
            ['name' => 'delete', 'group' => 'subcategories'],
            ['name' => 'view', 'group' => 'products'],
            ['name' => 'create', 'group' => 'products'],
            ['name' => 'update', 'group' => 'products'],
            ['name' => 'delete', 'group' => 'products'],
        ];

        $permissionIds = [];
        foreach ($permissions as $permissionData) {
            $permission = Permission::firstOrCreate($permissionData);
            $permissionIds[] = $permission->id;
        }

        echo "Seeder executed successfully: Full access granted.\n";
    }
}
