<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center gap-3" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('Karang Taruna.png') }}" alt="karang-taruna" class="img-fluid" width="40">
        </div>
        <div class="sidebar-brand-text">Karta Cileles</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <x-nav-link :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('kelola-bencana')" href="{{ route('kelola-bencana') }}">
        <i class="fas fa-heart-broken"></i>
        <span>Data Bencana</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('relawan')" href="{{ route('relawan') }}">
        <i class="fas fa-users"></i>
        <span>Data Relawan</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('data-donasi')" href="{{ route('data-donasi') }}">
        <i class="fas fa-fw fa-money-bill"></i>
        <span>Data Donasi</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('data-pakaian')" href="{{ route('data-pakaian') }}">
        <i class="fas fa-tshirt"></i>
        <span>Data Pakaian</span>
    </x-nav-link>
    
    <x-nav-link :active="request()->routeIs('penyaluran-pakaian')" href="{{ route('penyaluran-pakaian') }}">
        <i class="fas fa-hand-holding-heart"></i>
        <span>Penyaluran Pakaian</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('data-makanan')" href="{{ route('data-makanan') }}">
        <i class="fas fa-pizza-slice"></i>
        <span>Data Makanan</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('penyaluran-makanan')" href="{{ route('penyaluran-makanan') }}">
        <i class="fas fa-utensils"></i>
        <span>Penyaluran Makanan</span>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs()" href="">
        <i class="fas fa-newspaper"></i>
        <span>Kelola Berita</span>
    </x-nav-link>
    

    <!-- Nav Item - Pages Collapse Menu -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item active" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
