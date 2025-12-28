<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admins')->user();
        $data = [
            'newOrders' => $this->getNewOrders(),
            'pageViews' => $this->getPageViews(),
            'registeredUsers' => $this->getRegisteredUsers(),
            'uniqueVisitors' => $this->getUniqueVisitors(),
            'inventoryCount' => $this->getInventoryCount(),
            'directMessages' => $this->getDirectMessages(),
            'totalRevenue' => $this->getTotalRevenue(),
            'totalOrders' => $this->getTotalOrders(),
            'latestMembers' => $this->getLatestMembers(),
            'latestOrders' => $this->getLatestOrders(),
            'latestProducts' => $this->getLatestProducts(),
        ];
        return view('admin.dashboard', compact('admin', 'data'));
    }

    private function getNewOrders(int $days = 1): int
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        $ordersCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        return $ordersCount;
    }

    private function getPageViews(int $days = 7): int
    {
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();

        $ordersCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $products = Product::count();

        $pageViews = ($ordersCount * 15) + ($newUsers * 5) + ($products * 2);

        return (int) $pageViews;
    }

    private function getRegisteredUsers(int $days = 1): int
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->endOfDay();

        $users = User::whereBetween('created_at', [$startDate, $endDate])->count();
        return $users;
    }


    private function getUniqueVisitors(int $days = 7): int
    {
        $startDate = now()->subDays($days)->startOfDay();
        $endDate = now()->endOfDay();
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        if ($newUsers > 0) {
            return (int) $newUsers;
        }
        if (Schema::hasColumn('orders', 'user_id')) {
            $uniqueFromOrders = Order::whereBetween('created_at', [$startDate, $endDate])
                ->distinct('user_id')
                ->count('user_id');
            if ($uniqueFromOrders > 0) {
                return (int) $uniqueFromOrders;
            }
        }
        return 1;
    }

    private function getInventoryCount()
    {
        return Product::sum('quantity');
    }
    private function getDirectMessages(int $days = 1): int
    {
        $startDate = now()->subDays($days - 1)->startOfDay();
        $endDate = now()->toDateString();
        return Chat::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getTotalRevenue(): float
    {
        return (float) Order::whereIn('status', ['paid', 'completed'])->sum('total_amount');
    }

    private function getTotalOrders(): float
    {
        return (float) Order::whereIn('status', ['paid', 'completed'])->count();
    }

    private function getLatestMembers()
    {
        return User::select('id', 'avatar', 'name', 'created_at')
            ->latest('created_at')
            ->take(8)
            ->get();
    }

    private function getLatestOrders()
    {
        $orders = Order::with('items')
            ->latest('created_at')
            ->take(8)
            ->get();
        $orderData = [];
        foreach ($orders as $order) {
            $orderData[] = [
                'order_number' => $order->order_number,
                'items_count'  => $order->items->count(),
                'status'       => $order->status,
            ];
        }
        return $orderData;
    }

    private function getLatestProducts()
    {
        $products = Product::select('id', 'name', 'image', 'description', 'price')
            ->latest('created_at')
            ->take(4)
            ->get();
        return $products;
    }
}
