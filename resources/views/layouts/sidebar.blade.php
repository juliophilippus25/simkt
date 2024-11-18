<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
        <img src="{{ asset('images/simkt.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">SIMKT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @auth('user')
                    @if (Auth::guard('user')->user()->profile->photo)
                        <img src="{{ asset('storage/users/foto/' . Auth::guard('user')->user()->profile->photo) }}"
                            class="img-circle elevation-2" alt="User Image"
                            style="width: 35px; height: 35px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="img-circle elevation-2" alt="User Image"
                            style="width: 35px; height: 35px; object-fit: cover;">
                    @endif
                    @elseauth('admin')
                    @if (Auth::guard('admin')->user()->avatar)
                        <img src="{{ asset('storage/admins/avatar/' . Auth::guard('admin')->user()->avatar) }}"
                            class="img-circle elevation-2" alt="User Image"
                            style="width: 35px; height: 35px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="img-circle elevation-2" alt="User Image"
                            style="width: 35px; height: 35px; object-fit: cover;">
                    @endif
                @endauth
            </div>
            <div class="info">
                @auth('admin')
                    <a href="{{ route('admin.profile') }}" class="d-block">
                        {{ Auth::guard('admin')->user()->name }}
                    </a>
                    @elseauth('user')
                    <a href="{{ route('user.profile') }}" class="d-block">
                        {{ Auth::guard('user')->user()->profile->name }}
                    </a>
                @endauth
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @auth('admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->is('admin/penghuni*') ? 'menu-open' : '' }} || {{ request()->is('admin/manajemen-admin*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/penghuni*') ? 'active' : '' }} || {{ request()->is('admin/manajemen-admin*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Pengguna
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (Auth::guard('admin')->user()->role == 'superadmin')
                                <li class="nav-item">
                                    <a href="{{ route('admin.admin.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.admin.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Admin</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }} || {{ request()->routeIs('admin.users.show') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penghuni</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ request()->is('admin/asrama*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin/asrama*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bed"></i>
                            <p>
                                Asrama
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item ">
                                <a href="{{ route('admin.room.putra') }}"
                                    class="nav-link {{ request()->routeIs('admin.room.putra') ? 'active' : '' }} || {{ request()->routeIs('admin.room.putra.show') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Putra</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.room.putri') }}"
                                    class="nav-link {{ request()->routeIs('admin.room.putri') ? 'active' : '' }} || {{ request()->routeIs('admin.room.putri.show') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Putri</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ request()->is('admin/pengajuan-penghuni*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/pengajuan-penghuni*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Pengajuan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item {{ request()->is('admin/pengajuan-penghuni*') ? 'menu-open' : '' }}">
                                <a href="{{ route('admin.penghuni.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.penghuni.index') || request()->routeIs('admin.penghuni.show') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penghuni</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.penghuni.out') }}"
                                    class="nav-link {{ request()->routeIs('admin.penghuni.out') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Keluar Asrama</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.extension.index') }}"
                            class="nav-link {{ request()->routeIs('admin.extension.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>
                                Perpanjangan
                            </p>
                        </a>
                    </li>
                @endauth

                @auth('user')
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}"
                            class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->is('user/penghuni*') ? 'menu-open' : '' }} || {{ request()->is('user/keluar-penghuni*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('user/penghuni*') ? 'active' : '' }} || {{ request()->is('user/keluar-penghuni*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Pengajuan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('user.penghuni') }}"
                                    class="nav-link {{ request()->routeIs('user.penghuni') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penghuni</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.penghuni.out') }}"
                                    class="nav-link {{ request()->routeIs('user.penghuni.out') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Keluar Asrama</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth

                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
