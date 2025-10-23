<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ Auth::guard('admins')->check() ? route('admin.dashboard', app()->getLocale()) : route('vendor.dashboard', app()->getLocale()) }}"
            class="brand-link">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">
                {{ Auth::guard('admins')->check() ? 'Admin Dashboard' : 'Vendor Dashboard' }}
            </span>
        </a>
    </div>

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ Auth::guard('admins')->check() ? route('admin.dashboard', app()->getLocale()) : route('vendor.dashboard', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs(Auth::guard('admins')->check() ? 'admin.dashboard*' : 'vendor.dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ Auth::guard('admins')->check() ? 'Overview' : 'Dashboard' }}</p>
                    </a>
                </li>

                <!-- Admin-only Links -->
                @if (Auth::guard('admins')->check())
                    <!-- Vendors -->
                    <li class="nav-item {{ request()->is('*admin/vendors*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('*admin/vendors*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>
                                Vendors
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.vendors.index', app()->getLocale()) }}"
                                    class="nav-link {{ request()->routeIs('admin.vendors.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>All Vendors</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.vendors.pending', app()->getLocale()) }}"
                                    class="nav-link {{ request()->routeIs('admin.vendors.pending') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Pending Vendors</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Users -->
                    <li class="nav-item {{ request()->is('*admin/users*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('*admin/users*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>
                                Users
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index', app()->getLocale()) }}"
                                    class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Common Links (Products, Brands, Categories, Coupons, Orders, Reports) -->
                @php $prefix = Auth::guard('admins')->check() ? 'admin.' : 'vendor.'; @endphp

                <!-- Products -->
                <li class="nav-item {{ request()->is('*products*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*products*') ? 'active' : '' }}">
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
                                <p>All Products</p>
                            </a>
                        </li>
                        @if ($prefix == 'vendor.')
                            <li class="nav-item">
                                <a href="{{ route($prefix . 'products.create', app()->getLocale()) }}"
                                    class="nav-link {{ request()->routeIs($prefix . 'products.create') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>Add New Product</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Brands -->
                <li class="nav-item {{ request()->is('*brands*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*brands*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>
                            Brands
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'brands.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('brands.index', app()->getLocale()) ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'brands.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('brands.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Categories -->
                <li class="nav-item {{ request()->is('*categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*categories*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Categories
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'categories.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'categories.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'categories.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'categories.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Category</p>
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

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'orders.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <!-- Reports (Admin only) -->
                @if (Auth::guard('admins')->check())
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
                @endif

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
                <li class="nav-header">EXAMPLES</li>
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
                </li>

            </ul>
        </nav>
    </div>
</aside>
<!--end::Sidebar-->
