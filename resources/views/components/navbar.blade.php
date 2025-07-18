@if (Request::is('login'))
@else
    <nav class="navbar navbar-expand-lg sticky-top bg-danger" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('Karang Taruna.png') }}" alt="Logo" width="30"
                    class="d-inline-block align-text-top me-2">
                Karang Taruna Cileles
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <x-nav-link :active="request()->routeIs('/')" href="{{ route('/') }}">Beranda</x-nav-link>
                    <x-nav-link :active="request()->routeIs('berita')" href="{{ route('berita') }}">Berita</x-nav-link>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Data Bantuan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('donatur') }}">Data Donatur</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('pakaian') }}">Data Pakaian</a></li>
                            <li><a class="dropdown-item" href="{{ route('makanan') }}">Data Makanan</a></li>
                        </ul>
                    </li>
                    <x-nav-link :active="request()->routeIs('pascaBencana')" href="{{ route('pascaBencana') }}">Pasca Bencana</x-nav-link>
                    <x-nav-link :active="request()->routeIs('donasi')" href="{{ route('donasi') }}">
                        Donasi
                    </x-nav-link>
                    <x-nav-link :active="request()->routeIs('formRelawan')" href="{{ route('formRelawan') }}">
                        Daftar Relawan
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>
@endif
