<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.admin.{adminId}', function ($admin, $adminId) {
    return (int) $admin->id === (int) $adminId;
});

Broadcast::channel('chat.vendor.{vendorId}', function ($vendor, $vendorId) {
    return (int) $vendor->id === (int) $vendorId;
});






// Pusher

Broadcast::channel('chat.admin.{adminId}', function ($admin, $adminId) {
    return (int) $admin->id === (int) $adminId;
});
Broadcast::channel('chat.customer.{customerId}', function ($user, $customerId) {
    return (int) $user->id === (int) $customerId;
});
