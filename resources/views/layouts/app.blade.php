<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    @include('layouts.header')

    <div class="flex-grow flex items-center justify-center">
        <div class="w-full @if(request()->routeIs('login') || request()->routeIs('register')) max-w-md @else max-w-8xl @endif bg-white rounded-lg shadow-md">
            @yield('content')
        </div>
    </div>

    @include('layouts.footer')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
