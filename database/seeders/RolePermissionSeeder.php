<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions for vendors
        $vendorPermissions = [
            'create product',
            'edit product',
            'view product',
            'view own products',
            'delete product',
            'view own orders',
            'update order status',
            'update vendor profile',
            'manage shipping methods',
            'manage shipping rates',
        ];

        foreach ($vendorPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'vendors']);
        }

        $vendor = Role::firstOrCreate(['name' => 'vendor', 'guard_name' => 'vendors']);
        $vendor->syncPermissions($vendorPermissions);

        // Permissions for admins
        $adminPermissions = [
            'manage users',
            'manage vendors',
            'manage products',
            'manage shipping',
            'view all orders',
            'manage settings'
        ];

        foreach ($adminPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'admins']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admins']);
        $admin->syncPermissions($adminPermissions);

        // Permissions for customers
        $customerPermissions = [
            'place order',
            'update user profile',
            'change user password',
            'view products',
            'add to cart',
            'checkout',
            'view own orders'
        ];

        foreach ($customerPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customer->syncPermissions($customerPermissions);
    }
}
