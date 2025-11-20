<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\DateRange;

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
        $propertyId = 513371401;
        $client = new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google-analytics/google-analytics.json'),
        ]);

        $request = new RunReportRequest([
            'property' => 'properties/' . $propertyId,
            'metrics' => [new Metric(['name' => 'screenPageViews'])],
            'date_ranges' => [new DateRange(['start_date' => now()->subDays($days)->toDateString(), 'end_date' => now()->toDateString()])]
        ]);

        $response = $client->runReport($request);
        if ($response->getRowCount() === 0) {
            return 0;
        }
        return (int) $response->getRows()[0]->getMetricValues()[0]->getValue() ?? 0;
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
        $propertyId = 513371401;
        $client = new BetaAnalyticsDataClient([
            'credentials' => storage_path('app/google-analytics/google-analytics.json'),
        ]);

        $startDate = now()->subDays($days)->toDateString();
        $endDate = now()->toDateString();

        $request = new RunReportRequest([
            'property' => 'properties/' . $propertyId,
            'metrics' => [
                new Metric(['name' => 'totalUsers']),
            ],
            'date_ranges' => [
                new DateRange(['start_date' => $startDate, 'end_date' => $endDate])
            ],
            'limit' => 1
        ]);

        $response = $client->runReport($request);
        if ($response->getRowCount() === 0) {
            return 0;
        }

        return (int) $response->getRows()[0]->getMetricValues()[0]->getValue();
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
            foreach ($order->items as $item) {
                $orderData[] = [
                    'order_number' => $order->order_number,
                    'product_name' => $item->product_name,
                    'status'       => $order->status,
                ];
            }
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
