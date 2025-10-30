<?php

namespace App\Http\Controllers\Vendor\Wallet\Withdraw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Withdrawal;

class WithdrawController extends Controller
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
        $requests = $vendor->withdraw()->paginate(10);
        return view('vendor.wallet.withdraw.index', compact('requests'));
    }
    public function create()
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $totalCredits = $vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        return view('vendor.wallet.withdraw.create', compact('balance'));
    }

    public function store($lang, Request $request)
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $totalCredits = $vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'notes' => 'nullable|string|max:1000',
        ]);
        $withdrawal = Withdrawal::create([
            'vendor_id' => $vendor->id,
            'amount' => $validated['amount'],
            'notes' => $validated['notes'] ?? null,
        ]);
        if (!$withdrawal) {
            return back()->with('error', 'Failed to request withdrawal.');
        }
        return back()->with('success', 'Withdrawal request submitted successfully!');
    }

    public function edit($lang, $id)
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $withdraw = $vendor->withdraw()->where('id', $id)->firstOrFail();
        return view('vendor.wallet.withdraw.edit', compact('withdraw'));
    }

    public function destroy($lang, $id)
    {
        $vendor = auth()->guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login', app()->getLocale());
        }
        if (!$vendor->hasRole('vendor') || !$vendor->can('manage shipping methods')) {
            abort(403, 'Unauthorized');
        }
        $withdraw = $vendor->withdraw()->where('id', $id)->delete();
        if (!$withdraw) {
            return back()->with('error', 'Failed to delete the request.');
        }
        return back()->with('success', 'Withdrawal request deleted successfully!');
    }
}
