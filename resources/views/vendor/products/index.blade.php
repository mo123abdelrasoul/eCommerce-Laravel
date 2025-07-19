@extends('layouts.app')

@section('title', 'Vendor Products')

@section('content')
<div class="dashboard-container flex min-h-screen">
    @include('vendor.layouts.Sidebar')

    <main class="content flex-1 p-4 bg-gray-100">
        <header class="mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Products</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <a href="{{ route('product.create', app()->getLocale()) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Product</a>
        </header>
        <section class="grid grid-cols-3 gap-4">
            @php
                $products = DB::table('products')->select('id','name','price','image')->whereNull('deleted_at')->get();
            @endphp
                @if(!$products->isEmpty())
                    @foreach($products as $product)
                        <div class="p-4 bg-white rounded-lg shadow">
                            <img src="{{ asset('storage/' . $product->image)}}" alt="{{$product->name}}" class="w-full h-40 object-cover rounded">
                            <a href="{{ route('product.edit',['id' => $product->id , 'lang' => app()->getLocale()]) }}"><h2 class="text-lg font-bold mt-2">{{$product->name}}</h2></a>
                            <p class="text-gray-600">{{$product->price}}</p>
                            <div class="mt-2 flex justify-between">
                                <a href="{{ route('product.edit',['id' => $product->id , 'lang' => app()->getLocale()]) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form
                                    action="{{ route('product.destroy',['id' => $product->id , 'lang' => app()->getLocale()]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                @else
                    {{ ("No Products Yet") }}
                @endif
        </section>
    </main>
</div>
@endsection
