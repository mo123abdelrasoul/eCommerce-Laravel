@extends('admin.layouts.app')

@section('title', 'Admin Profile')

@section('content')
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $admin->avatar) }}"
                        alt="Admin profile picture" style="width:150px; height:150px; object-fit:cover;border-radius:50%;">
                </div>

                <h3 class="profile-username text-center">{{ $admin->name }}</h3>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">{{ $admin->email }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <span class="float-right">{{ $admin->phone ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Joined</b> <span class="float-right">{{ $admin->created_at->format('d M Y') }}</span>
                    </li>
                </ul>

                <a href="{{ route('admin.profile.edit', ['lang' => app()->getLocale(), 'profile' => $admin->id]) }}"
                    class="btn btn-warning btn-block"><b>Edit
                        Profile</b></a>
            </div>
        </div>

    </div>
@endsection
