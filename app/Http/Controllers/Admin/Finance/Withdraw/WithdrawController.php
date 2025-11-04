<?php

namespace App\Http\Controllers\Admin\Finance\Withdraw;

use App\Http\Controllers\Controller;
use App\Models\VendorWalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;


class WithdrawController extends Controller
{
    public function index()
    {
        $search = request('search');

        $withdrawals = Withdrawal::with('vendor')
            ->when($search, function ($query, $search) {
                $query->whereHas('vendor', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.finance.withdraw.index', compact('withdrawals'));
    }

    public function approve($lang, Request $request)
    {
        return $this->updateStatus($lang, $request, 'approved');
    }

    public function reject($lang, Request $request)
    {
        return $this->updateStatus($lang, $request, 'rejected');
    }

    private function updateStatus($lang, Request $request, $status)
    {
        $validated = $request->validate([
            'withdraw_id' => 'required|exists:withdrawals,id',
        ]);
        try {
            DB::beginTransaction();
            $withdrawal = Withdrawal::findOrFail($validated['withdraw_id']);
            $withdrawal->status = $status;
            $withdrawal->save();
            if ($status === 'approved') {
                VendorWalletTransaction::create([
                    'vendor_id' => $withdrawal->vendor_id,
                    'amount' => -$withdrawal->amount,
                    'type' => 'debit',
                    'description' => 'Withdrawal request approved',
                ]);
            }
            DB::commit();
            return redirect()->route('admin.withdraw.index', app()->getLocale())
                ->with('success', "Withdrawal request {$status} successfully.");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.withdraw.index', app()->getLocale())
                ->with('error', "An error occurred while {$status} the withdrawal request.");
        }
    }
}
