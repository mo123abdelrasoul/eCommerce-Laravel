<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Admin Dashboard</span>
        </a>
    </div>

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('vendor.dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Overview
                        </p>
                    </a>
                </li>

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
                            <a href="{{ route('vendors.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('vendors.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Vendors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vendors.pending', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('vendors.pending') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pending Vendors</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Brands -->
                <li class="nav-item {{ request()->is('*/brands*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*/brands*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>
                            Brands
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('brands.index') }}"
                                class="nav-link {{ request()->routeIs('brands.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brands.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('brands.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Categories -->
                <li class="nav-item {{ request()->is('*/categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*/categories*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Categories
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}"
                                class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Coupons -->
                <li class="nav-item {{ request()->is('*/coupons*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*/coupons*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <p>
                            Coupons
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('coupons.index') }}"
                                class="nav-link {{ request()->routeIs('coupons.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('coupons.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('coupons.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Coupon</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}"
                        class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>
                            Orders
                            {{-- <span class="nav-badge badge text-bg-info me-3">6</span> --}}
                        </p>
                    </a>
                </li>

                <!-- Reports -->
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

                <!-- Settings Header -->
                <li class="nav-header">SETTINGS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('vendor.profile.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-gear"></i>
                        <p>Profile</p>
                    </a>
                </li>

                <!-- Multi Level Example -->
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-circle-fill text-danger"></i>
                        <p class="text">Important</p>
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
