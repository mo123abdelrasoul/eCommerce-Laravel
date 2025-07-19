@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="dashboard-container flex min-h-screen">
    <aside class="sidebar w-1/6 bg-gray-800 text-white p-4 min-h-screen">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <ul class="space-y-2">
            <li><a href="#" class="block py-2 px-4 bg-gray-700 rounded">Admin Dashboard</a></li>
            <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Products</a></li>
            <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Orders</a></li>
            <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Earnings</a></li>
            <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Settings</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 px-4 bg-red-600 hover:bg-red-700 rounded">Logout</button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="content flex-1 p-4 bg-gray-100">
        <header class="mb-4">
            <h1 class="text-2xl font-bold"> Dashboard</h1>
        </header>

        <section class="grid grid-cols-3 gap-4 mb-4">
            <div class="p-4 bg-blue-500 text-white rounded-lg shadow">Total Sales: <span class="font-bold">$5,230</span></div>
            <div class="p-4 bg-green-500 text-white rounded-lg shadow">Orders: <span class="font-bold">34</span></div>
            <div class="p-4 bg-yellow-500 text-white rounded-lg shadow">Products: <span class="font-bold">12</span></div>
        </section>

        <section class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Recent Orders</h2>
            <table class="w-full border-collapse border border-gray-300">
                <tr class="bg-gray-100">
                    <th class="border p-2">Order ID</th>
                    <th class="border p-2">Customer</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Total</th>
                </tr>
                <tr>
                    <td class="border p-2">#1234</td>
                    <td class="border p-2">John Doe</td>
                    <td class="border p-2 text-green-600">Shipped</td>
                    <td class="border p-2">$120</td>
                </tr>
                <tr>
                    <td class="border p-2">#1235</td>
                    <td class="border p-2">Jane Smith</td>
                    <td class="border p-2 text-yellow-600">Pending</td>
                    <td class="border p-2">$80</td>
                </tr>
            </table>
        </section>
    </main>
</div>
@endsection
