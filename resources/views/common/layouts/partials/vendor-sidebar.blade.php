<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow vendor" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('vendor.dashboard', app()->getLocale()) }}" class="brand-link">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">
                {{ 'Vendor Dashboard' }}
            </span>
        </a>
    </div>

    <!--begin::Sidebar Wrapper-->
    @php $prefix = 'vendor.'; @endphp
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('vendor.dashboard', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs('vendor.dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ 'Dashboard' }}</p>
                    </a>
                </li>
                <!-- Products -->
                <li
                    class="nav-item
    {{ request()->routeIs($prefix . 'products.*') || request()->routeIs($prefix . 'categories.*') || request()->routeIs($prefix . 'brands.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'products.*') || request()->routeIs($prefix . 'categories.*') || request()->routeIs($prefix . 'brands.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Products
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'products.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'products.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'categories.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'categories.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'brands.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'brands.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Coupons -->
                <li class="nav-item {{ request()->routeIs($prefix . 'coupons.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'coupons.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-percent"></i>
                        <p>
                            Coupons
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'coupons.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'coupons.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'coupons.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'coupons.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Coupon</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Shipping -->
                <li
                    class="nav-item
    {{ request()->routeIs($prefix . 'shipping.methods.*') || request()->routeIs($prefix . 'rates.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link
        {{ request()->routeIs($prefix . 'shipping.methods.*') || request()->routeIs($prefix . 'rates.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-truck"></i>
                        <p>
                            Shipping
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'shipping.methods.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'shipping.methods.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Methods</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'rates.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'rates.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Rates</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'orders.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs($prefix . 'orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>


                <!-- Wallet -->
                <li class="nav-item {{ request()->routeIs($prefix . 'wallet.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'wallet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-wallet2"></i>
                        <p>
                            Wallet
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'wallet.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'wallet.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Overview</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'withdraw.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'withdraw.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Withdrawals</p>
                            </a>
                        </li>
                    </ul>
                </li>







                <!-- Settings -->
                <li class="nav-header">SETTINGS</li>

                <li class="nav-item">
                    <a href="{{ route($prefix . 'profile.index', app()->getLocale()) }}" class="nav-link">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>Profile</p>
                    </a>
                </li>

                <!-- Examples -->
                {{-- <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill text-danger"></i>
                        <p>Important</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill text-warning"></i>
                        <p>Warning</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill text-info"></i>
                        <p>Informational</p>
                    </a>
                </li> --}}

            </ul>
        </nav>
    </div>
</aside>
<!--end::Sidebar-->








<!-- resources/views/vendor/layouts/app.blade.php أو أي Blade عام للفيندور -->
@php
    $vendorId = auth()->guard('vendors')->id();
@endphp
<div id="vendor-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <!-- زرار الفتح مع Badge -->
    <button id="chat-toggle" class="btn btn-primary position-relative rounded-circle"
        style="width: 60px; height: 60px;">
        <i class="bi bi-chat-dots fs-4"></i>
        {{-- <span id="chat-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            0
        </span> --}}
    </button>

    <div id="chat-window" class="card shadow"
        style="width: 300px; height: 400px; display: none; flex-direction: column; margin-top: 10px;">
        <div class="card-header bg-primary text-white position-relative">
            <span>Chat with Admin</span>
            <button id="chat-close" class="btn btn-sm btn-light position-absolute top-50 translate-middle-y"
                style="right: 8px;">&times;</button>
        </div>

        <div class="card-body overflow-y-auto" id="chat-messages" style="flex-grow: 1;">
            <div class="mb-3 text-start chat">
            </div>
        </div>
        <div class="card-footer">
            <form id="chat-form">
                @csrf
                <div class="input-group">
                    <input type="text" id="chat-input" class="form-control" placeholder="Type a message..."
                        required>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const fetchMessagesUrl =
        "{{ route('vendor.chats.load.messages', ['lang' => app()->getLocale()]) }}";
    const vendorSendMessageUrl = "{{ route('vendor.chat.send.message', ['lang' => app()->getLocale()]) }}";
    let vendorId = {{ $vendorId }}
</script>
