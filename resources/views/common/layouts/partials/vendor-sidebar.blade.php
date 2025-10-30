<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
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
    {{ request()->is('*products*') || request()->is('*categories*') || request()->is('*brands*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('*products*') || request()->is('*categories*') || request()->is('*brands*') ? 'active' : '' }}">
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
                <li class="nav-item {{ request()->is('*coupons*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*coupons*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
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
    {{ request()->is('*cities*') || request()->is('*regions*') || request()->is('*shipping/methods*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link 
        {{ request()->is('*cities*') || request()->is('*regions*') || request()->is('*shipping/methods*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
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
                        class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>


                <!-- Wallet -->
                <li class="nav-item {{ request()->routeIs($prefix . 'wallet.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'wallet.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
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





                <li class="nav-item {{ request()->is('reports*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-bar-chart-fill"></i>
                        <p>
                            Reports
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>User Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Settings</p>
                    </a>
                </li>
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
