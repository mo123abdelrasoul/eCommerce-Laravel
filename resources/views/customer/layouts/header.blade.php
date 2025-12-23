<header class="bg-white shadow-md sticky-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            <!-- Logo -->
            <a href="{{ route('home', app()->getLocale()) }}" class="h4 mb-0 fw-bold text-primary text-decoration-none">
                Mstore24
            </a>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="btn btn-link d-md-none text-dark p-0" type="button">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Navigation -->
            <nav id="mobile-menu" class="d-none d-md-flex align-items-center gap-4">
                <a href="{{ route('home', app()->getLocale()) }}" class="text-decoration-none text-secondary hover-primary">{{ __('home') }}</a>
                <a href="{{ url(app()->getLocale() . '/shop') }}" class="text-decoration-none text-secondary hover-primary">{{ __('shop') }}</a>
                <a href="{{ url(app()->getLocale() . '/about') }}" class="text-decoration-none text-secondary hover-primary">{{ __('about_us') }}</a>
                <a href="{{ url(app()->getLocale() . '/contact') }}" class="text-decoration-none text-secondary hover-primary">{{ __('contact') }}</a>
            </nav>

            <!-- Icons & Language Switcher -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <!-- Language Switcher -->
                @if(app()->getLocale() == 'en')
                    <a href="{{ route('change.language', ['language' => 'ar']) }}" class="d-flex align-items-center text-decoration-none text-secondary hover-primary gap-1">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <span class="small">{{ __('arabic') }}</span>
                    </a>
                @else
                    <a href="{{ route('change.language', ['language' => 'en']) }}" class="d-flex align-items-center text-decoration-none text-secondary hover-primary gap-1">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <span class="small">{{ __('english') }}</span>
                    </a>
                @endif

                @auth('web')
                    <a href="{{ route('user.profile.index', app()->getLocale()) }}" class="d-flex align-items-center text-decoration-none text-secondary hover-primary gap-1">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="small">{{ Auth::guard('web')->user()->name }}</span>
                    </a>
                @else
                    <a href="{{ route('user.login', app()->getLocale()) }}" class="d-flex align-items-center text-decoration-none text-secondary hover-primary gap-1">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="small">{{ __('login') }}</span>
                    </a>
                @endauth

                <!-- Cart -->
                <a href="{{ route('user.cart.index', app()->getLocale()) }}" onclick="event.preventDefault(); if(window.toggleCart) { window.toggleCart(); }" class="position-relative text-decoration-none text-secondary hover-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @php
                        $cartCount = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $id => $details) {
                                $cartCount += 1;
                            }
                        }
                    @endphp
                    <span id="cart-badge" class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger{{ $cartCount > 0 ? '' : ' d-none' }}">
                        {{ $cartCount }}
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>

<style>
.hover-primary:hover {
    color: var(--bs-primary) !important;
}
</style>
