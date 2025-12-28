<!-- resources/views/layouts/partials/adminlte-header.blade.php -->
<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Navbar Left -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>

        <!-- Navbar Right -->
        <ul class="navbar-nav ms-auto">
            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display:none;"></i>
                </a>
            </li>

            <!-- User Menu -->
            @php
                $guard = isset($guard) ? $guard : (Auth::guard('admins')->check() ? 'admins' : 'vendors');
                $user = Auth::guard($guard)->user();
                $logoutRoute =
                    $guard === 'admins'
                        ? route('admin.logout.submit', ['lang' => app()->getLocale()])
                        : route('vendor.logout.submit', ['lang' => app()->getLocale()]);
                $profileRoute =
                    $guard === 'admins'
                        ? route('admin.profile.index', ['lang' => app()->getLocale()])
                        : route('vendor.profile.index', ['lang' => app()->getLocale()]);

                $logoutMethod = 'POST';
            @endphp

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="user-image rounded-circle shadow"
                        alt="User Image" />
                    <span class="d-none d-md-inline">{{ $user->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('assets/images/user2-128x128.jpg') }}" class="rounded-circle shadow"
                            alt="User Image" />
                        <p>
                            {{ $user->name ?? '' }}
                            <small>{{ $guard }} </small>
                            {{-- {{ $user->created_at?->format('M. Y') ?? 'N/A' }} --}}
                        </p>
                    </li>

                    <li class="user-footer">
                        <a href="{{ $profileRoute }}" class="btn btn-default btn-flat">Profile</a>
                        <form method="POST" action="{{ $logoutRoute }}" class="d-inline">
                            @csrf
                            @method($logoutMethod)
                            <button type="submit" class="btn btn-default btn-flat float-end">Sign out</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
