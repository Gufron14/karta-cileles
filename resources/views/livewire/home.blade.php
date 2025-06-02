<div>
    <header>
        <!-- Background image -->
        <div class="text-center bg-image"
            style="
      background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');
      height: 400px;
    ">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6); width: 100%; height: 100%;">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">Heading</h1>
                        <h4 class="mb-3">Subheading</h4>
                        <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="#!" role="button">Call
                            to action</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background image -->
    </header>

    <div class="container mt-5 mb-5">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body p-5">
                <div class="d-flex align-items-center">
                    <div class="col">
                        <h4 class="fw-bold">Rp100.000</h4>
                        <span>Dana Terkumpul</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">23</h4>
                        <span>Donatur</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">56</h4>
                        <span>Relawan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mb-3" style="background-color: #f3f3f3;">
        <div class="container p-5">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
                <img src="{{ asset('Karang Taruna.png') }}" alt="" width="48px">
                <span class="fw-bold h4">Karang Taruna Cileles</span>
            </div>
            <h4 class="mb-4 text-center">Karang Taruna Cileles mengajak kamu untuk berdonasi atau menjadi relawan bagi
                korban berbagai bencana.
                Sekecil apa pun bantuanmu, sangat berarti untuk mereka yang membutuhkan.

                Gabung sekarang – bersama kita kuat!</h4>
            <div class="d-flex mx-auto align-items-center justify-content-center gap-3">
                <a href="{{ route('donasi') }}" class="btn btn-danger btn-lg fw-bold">Donasi Sekarang</a>
                <a href="{{ route('formRelawan') }}" class="btn btn-outline-danger btn-lg fw-bold">Gabung Relawan</a>
            </div>
        </div>
    </div>

    {{-- Portal Berita --}}
    <div class="container mb-5 p-5">
        <h4 class="fw-bold text-center">Berita Terkini</h4>
    </div>

    {{-- Pasca Bencana --}}
    <div class="container">
        <h4 class="fw-bold text-center py-4">Pasca Bencana</h4>
        <!-- Gallery -->
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Wintry Mountain Landscape" />
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Mountains in the Clouds" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Waves at Sea" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Yosemite National Park" />
            </div>
        </div>
        <!-- Gallery -->
    </div>

    {{-- Kolaborasi --}}
    <div class="container p-5">
        <h4 class="fw-bold text-center">Jenis Kolaborasi/Bantuan</h4>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-4">
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
                    style="background-image: url('unsplash-photo-1.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Short title, long jacket</h3>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto"> <img src="https://github.com/twbs.png" alt="Bootstrap" width="32"
                                    height="32" class="rounded-circle border border-white"> </li>
                            <li class="d-flex align-items-center me-3"> <svg class="bi me-2" width="1em"
                                    height="1em" role="img" aria-label="Location">
                                    <use xlink:href="#geo-fill"></use>
                                </svg> <small>Earth</small> </li>
                            <li class="d-flex align-items-center"> <svg class="bi me-2" width="1em" height="1em"
                                    role="img" aria-label="Duration">
                                    <use xlink:href="#calendar3"></use>
                                </svg> <small>3d</small> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
                    style="background-image: url('unsplash-photo-2.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                        <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Much longer title that wraps to multiple lines
                        </h3>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto"> <img src="https://github.com/twbs.png" alt="Bootstrap" width="32"
                                    height="32" class="rounded-circle border border-white"> </li>
                            <li class="d-flex align-items-center me-3"> <svg class="bi me-2" width="1em"
                                    height="1em" role="img" aria-label="Location">
                                    <use xlink:href="#geo-fill"></use>
                                </svg> <small>Pakistan</small> </li>
                            <li class="d-flex align-items-center"> <svg class="bi me-2" width="1em"
                                    height="1em" role="img" aria-label="Duration">
                                    <use xlink:href="#calendar3"></use>
                                </svg> <small>4d</small> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg"
                    style="background-image: url('unsplash-photo-3.jpg');">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                        <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Another longer title belongs here</h3>
                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto"> <img src="https://github.com/twbs.png" alt="Bootstrap"
                                    width="32" height="32" class="rounded-circle border border-white"> </li>
                            <li class="d-flex align-items-center me-3"> <svg class="bi me-2" width="1em"
                                    height="1em" role="img" aria-label="Location">
                                    <use xlink:href="#geo-fill"></use>
                                </svg> <small>California</small> </li>
                            <li class="d-flex align-items-center"> <svg class="bi me-2" width="1em"
                                    height="1em" role="img" aria-label="Duration">
                                    <use xlink:href="#calendar3"></use>
                                </svg> <small>5d</small> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Benefit Relawan --}}
    <div class="container mb-5 p-5">
        <h4 class="fw-bold text-center">Benefit Menjadi Relawan Karang Taruna</h4>
        <div class="row g-4 py-4 row-cols-1 row-cols-lg-3">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('bantuan 1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Dapat membantu orang lain di masa sulit, relawan merasakan kepuasan batin
                            dan menjadikan hidup lebih bermanfaat serta bermakna.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Mengasah empati, keterampilan komunikasi, kerja sama tim, dan
                            kepemimpinan, serta memperluas wawasan sosial.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Dapat terlibat aktif dalam menyalurkan bantuan, mendampingi korban, dan
                            memulihkan kondisi lingkungan yang terdampak bencana.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panduan Umum --}}
        <div class="container mb-5 p-5">
            <h4 class="fw-bold text-center">Panduan Umum</h4>
        </div>

    </div>
