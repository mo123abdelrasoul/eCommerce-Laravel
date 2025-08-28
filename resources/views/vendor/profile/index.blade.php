@extends('layouts.app')

@section('title', 'Vendor Profile')

@section('content')
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $vendor->avatar) }}"
                        alt="Vendor profile picture" style="width:150px; height:150px; object-fit:cover;border-radius:50%;">
                </div>

                <h3 class="profile-username text-center">{{ $vendor->name }}</h3>
                <p class="text-muted text-center">{{ $vendor->company ?? 'Business Name' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">{{ $vendor->email }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <span class="float-right">{{ $vendor->phone ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Joined</b> <span class="float-right">{{ $vendor->created_at->format('d M Y') }}</span>
                    </li>
                </ul>

                <a href="{{ route('vendor.profile.edit', ['profile' => $vendor->id, 'lang' => app()->getLocale()]) }}"
                    class="btn btn-primary btn-block"><b>Edit
                        Profile</b></a>
            </div>
        </div>

    </div>
@endsection
