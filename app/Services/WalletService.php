<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Vendor;

class WalletService
{
    public function getVendorWalletSummary(Vendor $vendor): array
    {
        $transactions = $vendor->walletTransaction()->latest()->paginate(10);
        $totalCredits = $vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        $pendingEarnings = Order::where('vendor_id', $vendor->id)
            ->where(function ($q) {
                $q->where('status', '!=', 'completed')
                    ->orWhere('payment_status', '!=', 'paid');
            })
            ->sum('total_amount');

        return compact('transactions', 'totalCredits', 'totalDebits', 'balance', 'pendingEarnings');
    }
}
