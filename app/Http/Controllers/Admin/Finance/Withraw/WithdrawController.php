<?php

namespace App\Http\Controllers\Admin\Finance\Withraw;

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
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }
        $withdrawals = Withdrawal::paginate(10);
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
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage shipping')) {
            abort(403, 'Unauthorized');
        }

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
