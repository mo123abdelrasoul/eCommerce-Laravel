<?php

namespace App\Http\Controllers\Vendor\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Order;

class WalletController extends Controller
{
    protected $vendor;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $transactions = $this->vendor->walletTransaction()->latest()->paginate(10);
        $totalCredits = $this->vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $this->vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        $pendingEarnings = Order::where('vendor_id', $this->vendor->id)
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
