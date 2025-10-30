<?php

namespace App\Http\Controllers\Vendor\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
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
        return view('vendor.wallet.index', compact(
            'transactions',
            'totalCredits',
            'totalDebits',
            'balance'
        ));
    }
}
