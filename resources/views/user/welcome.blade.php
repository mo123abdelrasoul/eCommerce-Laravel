@extends('layouts.app') <!-- تعني استخدام الـ layout الذي يحتوي على الهيدر والفوتر -->

@section('title', 'Home') <!-- العنوان الخاص بالصفحة -->

@section('content')
    <div class="text-center p-6">
        <h1 class="text-3xl font-bold mb-4">@lang('Welcome to the Home Page')</h1>
        <p class="text-lg">@lang('This is the home page. You can add some content here about your website, latest news, etc.')</p>
    </div>
@endsection
