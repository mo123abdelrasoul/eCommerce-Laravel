<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\Withdrawal;

class WithdrawService
{
    public function getBalance(Vendor $vendor): float
    {
        $totalCredits = $vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        return $totalCredits + $totalDebits;
    }

    public function createWithdrawal(Vendor $vendor, float $amount, ?string $notes = null): bool
    {
        return (bool) Withdrawal::create([
            'vendor_id' => $vendor->id,
            'amount' => $amount,
            'notes' => $notes,
        ]);
    }

    public function updateWithdrawal(Withdrawal $withdraw, float $amount, ?string $notes = null): bool
    {
        if ($withdraw->status == 'approved') {
            return false;
        }
        return $withdraw->update([
            'amount' => $amount,
            'notes' => $notes,
        ]);
    }

    public function deleteWithdrawal(Withdrawal $withdraw): bool
    {
        return (bool) $withdraw->delete();
    }
}
