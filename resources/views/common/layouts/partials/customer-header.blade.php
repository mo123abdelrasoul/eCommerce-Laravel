<header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600">MyShop</a>

        {{-- Navigation --}}
        <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
            <a href="{{ url('/') }}" class="hover:text-blue-600">Home</a>
            <a href="{{ url('/shop') }}" class="hover:text-blue-600">Shop</a>
            <a href="{{ url('/about') }}" class="hover:text-blue-600">About</a>
            <a href="{{ url('/contact') }}" class="hover:text-blue-600">Contact</a>

            @auth('web')
                <form action="{{ route('user.logout.submit', ['lang' => app()->getLocale()]) }}" method="POST"
                    class="inline">
                    @csrf
                    <button type="submit" class="hover:text-blue-600">Logout</button>
                </form>
            @else
                <a href="{{ route('user.login', ['lang' => app()->getLocale()]) }}" class="hover:text-blue-600">Login</a>
            @endauth
        </nav>

        {{-- Actions (Cart, User, Language) --}}
        <div class="flex items-center space-x-6">

            {{-- User Account --}}
            <a href="#" class="text-gray-600 hover:text-blue-600 flex items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A10.97 10.97 0 0112 15c2.39 0 4.598.747 6.379 2.004M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>

            {{-- Cart --}}
            <a href="{{ route('user.cart.index', app()->getLocale()) }}"
                class="relative text-gray-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h10a1 1 0 00.95-.68L21 9M7 13V6h13" />
                </svg>
                <span
                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 cart-count">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="md:hidden bg-white border-t px-6 py-4">
        <nav class="flex flex-col space-y-3 text-gray-700">
            <a href="{{ url('/') }}" class="hover:text-blue-600">Home</a>
            <a href="{{ url('/shop') }}" class="hover:text-blue-600">Shop</a>
            <a href="{{ url('/about') }}" class="hover:text-blue-600">About</a>
            <a href="{{ url('/contact') }}" class="hover:text-blue-600">Contact</a>
        </nav>
    </div>
</header>
