<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VendorWalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $admin = auth()->guard('admins')->user();
        $totalOrdersCount = Order::count();
        $totalOrdersAmount = Order::sum('total_amount');
        $totalSales = Order::where('status', 'completed')->sum('total_amount');
        $totalCanceledOrders = Order::where('status', 'cancelled')->sum('total_amount');
        $totalCanceledOrdersCount = Order::where('status', 'cancelled')->count();

        $totalCommission = 0;
        $withdrawalData = Withdrawal::sum('amount');
        $approvedWithdrawals = Withdrawal::where('status', 'approved')->sum('amount');
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->sum('amount');
        $earningTransactions = VendorWalletTransaction::where('type', 'credit')->sum('amount');
        $deductTransactions = VendorWalletTransaction::where('type', 'debit')->sum('amount');
        $totalVendorEarnings = $earningTransactions + $deductTransactions;
        $monthlyData = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $months = $monthlyData->pluck('month')->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)))->values();
        $salesData = $monthlyData->pluck('total')->values();
        if ($months->isEmpty()) {
            $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);
            $salesData = collect([0, 0, 0, 0, 0, 0]);
        }
        return view('admin.finance.index', compact(
            'totalOrdersCount',
            'totalOrdersAmount',
            'totalSales',
            'totalCanceledOrders',
            'totalCanceledOrdersCount',
            'totalCommission',
            'withdrawalData',
            'approvedWithdrawals',
            'pendingWithdrawals',
            'totalVendorEarnings',
            'months',
            'salesData'
        ));
    }
}
