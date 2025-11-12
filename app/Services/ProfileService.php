<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateVendor($vendor, array $data, ?\Illuminate\Http\UploadedFile $avatarFile = null): bool
    {
        if ($avatarFile) {
            if ($vendor->avatar && Storage::disk('public')->exists($vendor->avatar)) {
                Storage::disk('public')->delete($vendor->avatar);
            }
            $data['avatar'] = $avatarFile->store('uploads/vendors', 'public');
        } else {
            $data['avatar'] = $vendor->avatar;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }
        return $vendor->update($data);
    }

    public function handleAvatarUpload($vendor, $avatarFile)
    {
        if ($vendor->avatar && Storage::disk('public')->exists($vendor->avatar)) {
            Storage::disk('public')->delete($vendor->avatar);
        }
        return $avatarFile->store('uploads/vendors', 'public');
    }
}
