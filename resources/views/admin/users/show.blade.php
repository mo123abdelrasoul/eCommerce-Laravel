@extends('admin.layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid">
        <!-- Profile Header -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $user->avatar) }}"
                        alt="User profile picture" style="width:150px; height:150px; object-fit:cover;border-radius:50%;">
                </div>
                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email: </b> <span class="float-right">{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Phone: </b> <span class="float-right">{{ $user->phone ?: 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Joined: </b>
                        @if ($user->created_at === null)
                            <span class="float-right">No Date</span>
                        @else
                            <span class="float-right">{{ $user->created_at->format('d M Y') ?? '' }}</span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <b>Status: </b>
                        <span class="float-right">
                            @if ($user->deleted_at === null)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Deleted</span>
                            @endif
                        </span>
                    </li>
                </ul>
                <a href="{{ route('users.edit', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                    class="btn btn-primary btn-block"><b>Edit
                        Profile</b></a>
            </div>
        </div>

    </div>
@endsection
