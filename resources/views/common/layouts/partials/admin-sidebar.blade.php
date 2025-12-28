<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow admin" data-bs-theme="dark">
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
                        class="nav-link {{ request()->routeIs($prefix . 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ 'Dashboard' }}</p>
                    </a>
                </li>


                <!-- <li class="nav-item">
                    <a href="{{ route($prefix . 'dashboard.analytics', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs($prefix . 'dashboard.analytics') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>{{ 'Dashboard Analytics' }}</p>
                    </a>
                </li> -->

                <li class="nav-item">
                    <a href="{{ route($prefix . 'admins.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs($prefix . 'admins.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <p>{{ 'Admins' }}</p>
                    </a>
                </li>
                <!-- Vendors -->
                <li class="nav-item {{ request()->routeIs($prefix . 'vendors.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'vendors.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-shop"></i>
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
                <li class="nav-item {{ request()->routeIs($prefix . 'users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
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
                <li class="nav-item {{ request()->routeIs($prefix . 'categories.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'categories.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags"></i>
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
    {{ request()->routeIs($prefix . 'cities.*') || request()->routeIs($prefix . 'regions.*') || request()->routeIs($prefix . 'methods.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link
        {{ request()->routeIs($prefix . 'cities.*') || request()->routeIs($prefix . 'regions.*') || request()->routeIs($prefix . 'methods.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i>
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
                <li class="nav-item {{ request()->routeIs($prefix . 'brands.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'brands.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags-fill"></i>
                        <p>
                            Brands
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'brands.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'brands.index') ? 'active' : '' }}">
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
                        class="nav-link {{ request()->routeIs($prefix . 'coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <p>Coupons</p>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a href="{{ route($prefix . 'orders.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->routeIs($prefix . 'orders.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cart-fill"></i>
                        <p>Orders</p>
                    </a>
                </li>

                <!-- Products -->
                <li class="nav-item {{ request()->routeIs($prefix . 'products.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'products.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
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
                    </ul>
                </li>

                <!-- Finance -->
                <li
                    class="nav-item {{ request()->routeIs($prefix . 'finance.*') || request()->routeIs($prefix . 'withdraw.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'finance.*') || request()->routeIs($prefix . 'withdraw.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i>
                        <p>
                            Finance
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'finance.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'finance.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Overview</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'withdraw.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'withdraw.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Withdraw Requests</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs($prefix . 'email.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'email.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope"></i>
                        <p>
                            Email
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.email.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'email.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.email.test', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'email.test*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Test Email</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Chats -->
                <li
                    class="nav-item {{ request()->routeIs($prefix . 'vendor-chats.*') || request()->routeIs($prefix . 'customer-chats.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'vendor-chats.*') || request()->routeIs($prefix . 'customer-chats.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i>
                        <p>
                            Chats
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'vendor-chats.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'vendor-chats.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route($prefix . 'customer-chats.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs($prefix . 'customer-chats.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{--
                <li class="nav-item">
                    <a href="{{ route($prefix . 'chats.index', app()->getLocale()) }}"
                        class="nav-link {{ request()->is(app()->getLocale() . '/admin/chats*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i>
                        <p>Chats</p>
                    </a>
                </li> --}}


                <!-- Roles -->
                <li class="nav-item {{ request()->routeIs($prefix . 'roles.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs($prefix . 'roles.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock"></i>
                        <p>
                            Roles
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('admin.roles.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Create Role</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Permissions -->
                <li class="nav-item {{ request()->routeIs($prefix . 'permissions.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs($prefix . 'permissions.*') ? 'active' : '' }}">
                        <i class="bi bi-key"></i>
                        <p>
                            Permissions
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.create', app()->getLocale()) }}"
                                class="nav-link {{ request()->routeIs('admin.permissions.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Create Permission</p>
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
            </ul>
        </nav>
    </div>
</aside>
<!--end::Sidebar-->
