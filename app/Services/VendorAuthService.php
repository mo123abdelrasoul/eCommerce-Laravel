<?php

namespace App\Services;

use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class VendorAuthService
{
    public function attemptLogin(string $email, string $password)
    {
        $vendor = Vendor::where('email', $email)->first();

        if (!$vendor) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        if ($vendor->trashed()) {
            return ['success' => false, 'message' => 'Your account has been deactivated.'];
        }

        if (!Hash::check($password, $vendor->password)) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        return ['success' => true, 'vendor' => $vendor];
    }
}
