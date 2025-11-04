<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard', app()->getLocale()) }}" class="brand-link">
            <img src="{{ asset('assets/images/AdminLTELogo.png') }}" alt="Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">
                {{ 'Admin Dashboard' }}
            </span>
        </a>
    </div>
    <!--begin::Sidebar Wrapper-->
    @php $prefix = 'admin.'; @endphp
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'dashboard', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs($prefix . 'dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ 'Dashboard' }}</p>
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
                            <a href="{{ route($prefix . 'vendors.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'vendors.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Vendors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'vendors.pending', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'vendors.pending') ? 'active' : '' }}">
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
                            <a href="{{ route($prefix . 'users.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'users.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Users</p>
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
                            <a href="{{ route($prefix . 'cities.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'cities.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Cities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'regions.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'regions.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Regions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'methods.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'methods.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Methods</p>
                            </a>
                        </li>
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
                                class="nav-link {{ request()->routeIs($prefix . 'brands.index', app()->getLocale()) ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'brands.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'brands.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add New Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Coupons -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'coupons.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <p>Coupons</p>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'orders.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <!-- Finance -->
                <li
                    class="nav-item {{ request()->is('*finance*') || request()->is('*withdraw*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('*finance*') || request()->is('*withdraw*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i>
                        <p>
                            Finance
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'finance.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->is('*finance*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Overview</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'withdraw.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->is('*withdraw*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Withdraw Requests</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->is('*email*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*email*') ? 'active' : '' }}">
                        <i class="bi bi-envelope"></i>
                        <p>
                            Email
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.email.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->is('*email*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.email.test', app()->getLocale()) }}"
                                class="nav-link {{ request()->is('*email/test*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Test Email</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Chats -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'chats.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->is(app()->getLocale() . '/admin/chats*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i>
                        <p>Chats</p>
                    </a>
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
            </ul>
        </nav>
    </div>
</aside>
<!--end::Sidebar-->
