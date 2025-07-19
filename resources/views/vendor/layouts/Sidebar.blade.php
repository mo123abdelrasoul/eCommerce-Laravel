<aside class="sidebar w-1/6 bg-gray-800 text-white p-4 pt-6 min-h-screen">
    <h2 class="text-2xl font-bold mb-4">Vendor Panel</h2>
    <ul class="space-y-2">
        @php
            $links = [
                ['name' => 'Dashboard', 'route' => 'vendor.dashboard'],
                ['name' => 'Profile', 'route' => 'dashboard.profile'],
                ['name' => 'Products', 'route' => 'DashboardProductsPage'],
                ['name' => 'Orders', 'route' => 'DashboardOrdersPage'],
            ];
        @endphp
        @foreach ($links as $link)
            <li><a href="{{ route($link['route']) }}" class="block py-2 px-4 hover:bg-gray-700 rounded {{ Route::is($link['route']) ? 'bg-gray-700' : '' }}">{{ $link['name'] }}</a></li>
        @endforeach
        {{-- <li><a href="{{ route('vendor.dashboard') }}" class="block py-2 px-4 bg-gray-700 rounded">Vendor Dashboard</a></li>
        <li><a href="{{ route('DashboardProductsPage') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Products</a></li>
        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Orders</a></li>
        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Earnings</a></li>
        <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded">Settings</a></li> --}}
        <li>
            <form method="POST" action="{{ route('logout', app()->getLocale()) }}">
                @csrf
                <button type="submit" class="block w-full text-left py-2 px-4 bg-red-600 hover:bg-red-700 rounded">Logout</button>
            </form>
        </li>
    </ul>
</aside>
