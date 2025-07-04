<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title') | Pengaduan Etik</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

  <!-- ======= Top Bar ======= -->
  <!-- <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
        <i class="bi bi-phone"></i> +1 5589 55488 55
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </div> -->
   <!-- ======= Header ======= -->
   <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

    <h1 class="logo me-auto d-flex align-items-center" style="justify-content: flex-start;">
      <img src="{{ asset('assets/img/Logo Poltekkes Kemenkes Surabaya.png') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
      <a href="/" color: #000080; text-decoration: none;">POLKESBAYA BERETIKA</a>
    </h1>
    
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      {{-- <nav id="navbar" class="navbar order-last order-lg-0 ">
        <ul>
          <li><a class="nav-link scrollto {{ (request()->is('/')) ? 'active' : '' }}" href="/">Home</a></li>
          <li><a class="nav-link scrollto {{ (request()->is('tentang')) ? 'active' : '' }}" href="{{ url('tentang')}}">Tentang</a></li>
          <li><a class="nav-link scrollto {{ (request()->is('pengaduan.laporan')) ? 'active' : '' }}" href="{{ route('pengaduan.laporan', 'saya')}}">Pengaduan</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar --> --}}

    @auth('masyarakat')
      <a href="{{ url('SOP')}}" class="scrollto"style="font-family: Arial;">SOP Kode Etik</a>

      <a href="{{ route('user.logout')}}" class="appointment-btn scrollto" style="font-family: Arial;">Logout</a>
      @else
          <a href="{{ url('/storage/assets/SOP/SOP Penanganan Pelanggaran Kode Etik Tendik.pdf') }}" target="_blank" class="scrollto"style="font-family: Arial;">
    SOP Kode Etik
</a>


        <a href="{{ url('login')}}" class="appointment-btn scrollto"style="font-family: Arial;">Login</a>
      @endauth

    </div>
  </header><!-- End Header -->

  @yield('content')

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row justify-content-between">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>PENGADUAN ETIK</h3>
            <p>
              PENJAMINAN MUTU<br>
              POLTEKKES KEMENKES SURABAYA<br>

            </p>
          </div>

          {{-- <div class="col-lg-2 col-md-6 footer-links">
            <h4>Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="/">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ url('tentang')}}">Tentang</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ url('tentang')}}">Pengaduan</a></li>
            </ul>
          </div> --}}

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Kontak</h4>
            <ul>
              <p>
                <strong>Phone:</strong> 087850543457<br>
                <strong>Email:</strong> admin@poltekkes-surabaya.ac.id<br>
              </p>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto my-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span><a href="" target="_blank">IT</a></span></strong>. Poltekkes Kemenkes Surabaya
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        {{-- <a href="https://github.com/BayuPrayoga62" class="github"><i class="bx bxl-github"></i></a> --}}
        <a href="https://www.instagram.com/polkessbaya/" class="instagram"><i class="bx bxl-instagram"></i></a>
        <!-- <a href="https://www.linkedin.com/in/bayu-prayoga-b000a121a/" class="linkedin"><i class="bx bxl-linkedin"></i></a> -->
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @stack('prepend-script')
  <!-- Vendor JS Files -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  @stack('addon-script')

</body>

</html>
