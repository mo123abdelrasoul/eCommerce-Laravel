<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyShop')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    @vite(['resources/css/home.css'])
    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    @yield('layout-header')
    @yield('layout-cart')

    <main class="flex-grow">
        @yield('content')
    </main>

    @yield('layout-footer')

    @vite(['resources/js/home.js', 'resources/js/checkout.js', 'resources/js/cart.js'])
    @stack('scripts')
</body>

</html>
