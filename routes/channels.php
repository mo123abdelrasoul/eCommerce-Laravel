<?php

use Illuminate\Support\Facades\Broadcast;

// Admin channels
Broadcast::channel('chat.admin.{adminId}', function ($user, $adminId) {
    return auth('admins')->check() && (int) auth('admins')->id() === (int) $adminId;
});

// Vendor channels
Broadcast::channel('chat.vendor.{vendorId}', function ($user, $vendorId) {
    return auth('vendors')->check() && (int) auth('vendors')->id() === (int) $vendorId;
});

// Customer channels
Broadcast::channel('chat.customer.{customerId}', function ($user, $customerId) {
    return auth('web')->check() && (int) auth('web')->id() === (int) $customerId;
});
