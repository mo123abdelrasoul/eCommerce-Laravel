<?php

namespace App\Http\Controllers\Vendor\Wallet;

use App\Http\Controllers\Controller;
use App\Services\WalletService;

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

    public function index(WalletService $walletService)
    {
        $data = $walletService->getVendorWalletSummary($this->vendor);
        return view('vendor.wallet.index', $data);
    }
}
