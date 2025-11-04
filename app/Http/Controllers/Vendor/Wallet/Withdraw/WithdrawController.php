<?php

namespace App\Http\Controllers\Vendor\Wallet\Withdraw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class WithdrawController extends Controller
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
        $requests = $this->vendor->withdraw()->orderBy('created_at', 'desc')->paginate(10);
        return view('vendor.wallet.withdraw.index', compact('requests'));
    }
    public function create()
    {
        $balance = $this->vendor->getWalletBalance();
        return view('vendor.wallet.withdraw.create', compact('balance'));
    }

    public function store($lang, Request $request)
    {
        $totalCredits = $this->vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $this->vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'notes' => 'nullable|string|max:1000',
        ]);
        $withdrawal = Withdrawal::create([
            'vendor_id' => $this->vendor->id,
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
        $withdraw = $this->vendor->withdraw()->where('id', $id)->firstOrFail();
        return view('vendor.wallet.withdraw.edit', compact('withdraw'));
    }

    public function update($lang, Request $request, $id)
    {
        $withdraw = $this->vendor->withdraw()->where('id', $id)->firstOrFail();
        if ($withdraw->status == 'approved') {
            return back()->with('error', 'You cannot edit an approved withdrawal request.');
        }
        $totalCredits = $this->vendor->walletTransaction()->where('type', 'credit')->sum('amount');
        $totalDebits = $this->vendor->walletTransaction()->where('type', 'debit')->sum('amount');
        $balance = $totalCredits + $totalDebits;
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'notes' => 'nullable|string|max:1000',
        ]);
        $updated = $withdraw->update([
            'amount' => $validated['amount'],
            'notes' => $validated['notes'] ?? null,
        ]);
        if (!$updated) {
            return back()->with('error', 'Failed to update the withdrawal request.');
        }
        return back()->with('success', 'Withdrawal request updated successfully!');
    }


    public function destroy($lang, $id)
    {
        $withdraw = $this->vendor->withdraw()->where('id', $id)->delete();
        if (!$withdraw) {
            return back()->with('error', 'Failed to delete the request.');
        }
        return back()->with('success', 'Withdrawal request deleted successfully!');
    }
}
