<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyShop')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- مكتبة JS (Swiper مثال للـ Sliders) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    @stack('styles')
</head>

<body class="bg-gray-50">

    {{-- Header --}}
    @include('user.layouts.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('user.layouts.footer')
    @vite(['resources/css/home.css', 'resources/js/home.js'])
    @vite(['resources/js/checkout.js'])
    @vite(['resources/js/cart.js'])

    {{-- JS --}}
    @stack('scripts')
</body>

</html>
