<?php

namespace App\Http\Controllers\Vendor\Wallet\Withdraw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WithdrawService;

class WithdrawController extends Controller
{
    protected $vendor;
    protected $withdrawService;

    public function __construct(WithdrawService $withdrawService)
    {
        $this->middleware(function ($request, $next) {
            $this->vendor = auth()->guard('vendors')->user();
            return $next($request);
        });

        $this->withdrawService = $withdrawService;
    }

    public function index()
    {
        $requests = $this->vendor->withdraw()->orderBy('created_at', 'desc')->paginate(10);
        return view('vendor.wallet.withdraw.index', compact('requests'));
    }

    public function create()
    {
        $balance = $this->withdrawService->getBalance($this->vendor);
        return view('vendor.wallet.withdraw.create', compact('balance'));
    }

    public function store(Request $request)
    {
        $balance = $this->withdrawService->getBalance($this->vendor);
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'notes' => 'nullable|string|max:1000',
        ]);

        $success = $this->withdrawService->createWithdrawal(
            $this->vendor,
            $validated['amount'],
            $validated['notes'] ?? null
        );

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Withdrawal request submitted successfully!' : 'Failed to request withdrawal.'
        );
    }

    public function edit($lang, $id)
    {
        $withdraw = $this->vendor->withdraw()->where('id', $id)->firstOrFail();
        return view('vendor.wallet.withdraw.edit', compact('withdraw'));
    }

    public function update($lang, Request $request, $id)
    {
        $withdraw = $this->vendor->withdraw()->where('id', $id)->firstOrFail();

        $balance = $this->withdrawService->getBalance($this->vendor);
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'notes' => 'nullable|string|max:1000',
        ]);

        $success = $this->withdrawService->updateWithdrawal(
            $withdraw,
            $validated['amount'],
            $validated['notes'] ?? null
        );

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Withdrawal request updated successfully!' : 'Failed to update the withdrawal request.'
        );
    }

    public function destroy($lang, $id)
    {
        $withdraw = $this->vendor->withdraw()->where('id', $id)->firstOrFail();
        $success = $this->withdrawService->deleteWithdrawal($withdraw);

        return back()->with(
            $success ? 'success' : 'error',
            $success ? 'Withdrawal request deleted successfully!' : 'Failed to delete the request.'
        );
    }
}
