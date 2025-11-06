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
            'manage own products',
            'manage own orders',
            'view categories',
            'view brands',
            'print order invoice',
            'update order status',
            'update vendor profile',
            'manage shipping options',
            'create discount coupons',
            'manage own coupons',
            'manage own profile',
            'view sales reports',
            'manage dashboard',
            'view own wallet',
            'request withdraw',
            'admin viewer'
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
            'manage orders',
            'manage settings',
            'view reports',
            'manage categories',
            'manage brands',
            'manage coupons',
            'manage roles and permissions',
            'process refunds',
            'view dashboard',
            'manage profile',
            'manage finance',
            'manage chats',
            'manage emails'
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
