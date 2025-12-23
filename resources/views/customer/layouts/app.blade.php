<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mstore24')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" sizes="any">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Styles -->
    @vite(['resources/front/css/main.css', 'resources/front/js/main.js', 'resources/js/cart.js'])
    <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @stack('styles')
    <script>
        window.APP_URL = "{{ url('/') }}";
    </script>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('customer.layouts.header')
    @include('customer.layouts.cart')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('customer.layouts.footer')

    @include('common.layouts.partials.customer-chat')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    @stack('scripts')

    <script>
        @if (auth()->check())
            window.Customer = {
                id: {{ auth()->id() }}
            };
        @endif
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('show');
                });
            }

            // Initialize Bootstrap dropdowns manually as fallback
            const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            if (typeof bootstrap !== 'undefined') {
                dropdownElementList.forEach(function(dropdownToggleEl) {
                    new bootstrap.Dropdown(dropdownToggleEl);
                });
            }
        });
    </script>

</body>

</html>
