@if (Request::is('login'))
@else
    <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row">
                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5>Pelajari Lebih Tentang Relawan Karang Taruna Kec.Cileles </h5>
                    <div class="my-3">
                        <img src="{{ asset('Karang Taruna.png') }}" alt="" width="60px">
                        <span class="ms-2 fs-4">Karang Taruna Kecamatan Cileles</span>
                    </div>
                    <p>
                        Dimana kumpulan pemuda-pemudi yang peduli terhadap lingkungan sosial di wilayah Kecamatan Cileles. Mereka adalah generasi muda yang bergerak secara sukarela untuk membantu masyarakat melalui kegiatan sosial, kepemudaan, pemberdayaan, hingga penanganan masalah sosial di sekitar.
                    </p>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 d-flex align-items-center gap-2">
                    
                    <a href="{{ route('sk') }}" class="btn btn-danger">
                        Syarat dan Ketentuan
                    </a>
                    <a href="{{ route('faq') }}" class="btn btn-outline-danger">
                        Relawan punya Pertanyaan?
                    </a>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Section: Social media -->
        <section class="mb-4 text-center">
            <!-- Facebook -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #3b5998;"
                href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

            <!-- Twitter -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #55acee;"
                href="#!" role="button"><i class="fab fa-twitter"></i></a>

            <!-- Google -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #dd4b39;"
                href="#!" role="button"><i class="fab fa-google"></i></a>

            <!-- Instagram -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #ac2bac;"
                href="#!" role="button"><i class="fab fa-instagram"></i></a>

            <!-- Linkedin -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #0082ca;"
                href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
            <!-- Github -->
            <a data-mdb-ripple-init class="btn text-white btn-floating m-1" style="background-color: #333333;"
                href="#!" role="button"><i class="fab fa-github"></i></a>
        </section>
        <!-- Section: Social media -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2025 Copyright
            <span class="text-body" >Karang Taruna Kecamatan Cileles.</span>
        </div>
        <!-- Copyright -->
    </footer>
@endif
