<header class="bg-blue-500 text-white py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center px-4">
        <a href="{{ url('/') }}" class="text-2xl font-bold">Mohamed</a>

        <nav class="flex space-x-6">
            <ul class="flex space-x-6">
                <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                <li><a href="{{ route('about') }}" class="hover:underline">About</a></li>

                @auth
                    <!-- قائمة منسدلة لخيارات المستخدم -->
                    <li class="relative group">
                        <!-- أيقونة المستخدم -->
                        <button class="hover:underline focus:outline-none">
                            <i class="fas fa-user"></i> <!-- أيقونة المستخدم -->
                        </button>

                        <!-- قائمة تسجيل الخروج المنسدلة -->
                        <div class="dropdown-menu absolute right-0 hidden bg-blue-700 text-white rounded shadow-md mt-2 w-32">
                            <form method="POST" action="{{ route('logout', app()->getLocale()) }}">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-sm hover:bg-blue-600">Logout</button>
                            </form>

                            <!-- عرض رابط اللغة بناءً على اللغة الحالية -->
                            @if (app()->getLocale() == 'ar')
                                <a href="{{ route('change.language', ['language' => 'en']) }}" class="block px-4 py-2 text-sm hover:bg-blue-600">EN</a>
                            @else
                                <a href="{{ route('change.language', ['language' => 'ar']) }}" class="block px-4 py-2 text-sm hover:bg-blue-600">AR</a>
                            @endif
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:underline">Login</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="hover:underline">Register</a></li>
                    @endif
                @endauth
            </ul>
        </nav>
    </div>
</header>

