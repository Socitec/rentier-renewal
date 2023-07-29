<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>レンティア</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">

  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Noto+Sans+JP:wght@400;500;600;700;800&family=Zen+Kaku+Gothic+Antique:wght@900&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/slick/slick.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/slick/common.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/slick/slick-theme.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/default.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/default.date.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/default.time.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/calender.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/new_style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/new_my_style.css')}}">


  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Medilab - v4.3.0
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  @yield('style')

  <!-- SEO対策 -->
  <meta name="google-site-verification" content="bb1tz-LFnkSoV2WwmBV4h_OZnVKsIKh960fQrpmUL1U" />
  <meta name="description" content="「周りを気にせず気兼ねなく話したい女子会に！」「終電を気にせず楽しみたい！」そんなニーズに応えるべく、宿泊も可能なレンタルスペースとしてレンティアはサービス展開をしています。">
  <meta name="keywords" content="レンティア,レンタルスペース,民泊">
  <meta property="og:type" content="ページの種類" />
  <meta property="og:title" content="レンティア" />
  <meta property="og:description" content="「周りを気にせず気兼ねなく話したい女子会に！」「終電を気にせず楽しみたい！」そんなニーズに応えるべく、宿泊も可能なレンタルスペースとしてレンティアはサービス展開をしています。" />
  <meta property="og:site_name" content="レンティア" />
  <meta property="og:url" content="https://rentier.jp/" />
  <meta property="og:image" content="{{asset('assets/img/index_drinks.png')}}" />
  <!-- Twitterシェア時の表示形式指定 -->
  <meta name="twitter:card" content="summary_large_image" />
  <link rel="canonical" href="{{ url()->current() }}" />
</head>

<body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>
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
    <div class="header-inner d-flex align-items-center">

      <div class="logo me-auto"><a href="{{url('/')}}"><img src="{{asset('assets/img/header_logo.svg')}}" alt="logo"></a></div>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      @yield('nav')

    </div>
  </header><!-- End Header -->

  <!-- コンテンツの処理を実行 -->
  @yield('content')

  <!-- ======= Footer ======= -->
  <footer class="footer-bg">

    <div class="container footer__container">
      <div class="footer__logo-area">
        <img class="footer__logo-img" src="{{asset('assets/img/footer_logo.svg')}}" alt="logo">
        <p class="footer__copyright">
          © 2023 Ito Business Office LLC All Rights Reserved.
        </p>
      </div>
      <div class="footer__link-area">
        <div class="footer__link-box">
          <ul class="footer__link-list">
            <li class="footer__link-item"><a class="footer__link" href="{{url('/about')}}">レンティアとは</a></li>
            <li class="footer__link-item"><a class="footer__link" href="{{url('/company')}}">会社概要</a></li>
            <li class="footer__link-item"><a class="footer__link" href="{{url('/contact')}}">お問い合わせ</a></li>
          </ul>
        </div>
        <div class="footer__link-box">
          <ul class="footer__link-list">
            <li class="footer__link-item"><a class="footer__link" href="{{url('/landList')}}">土地を探したい</a></li>
            <li class="footer__link-item"><a class="footer__link" href="{{url('/propertyList')}}">物件を探したい</a></li>
            <li class="footer__link-item"><a class="footer__link" href="{{url('/rental')}}">宿泊・レンタルしたい</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- <div class="container">

      <div class="text-center">
        <div class="copyright">
          &copy; Copyright <strong><span>Ito Business Office LLC</span></strong> All Rights Reserved
        </div>
        <div class="credits">-->
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
    <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
    <!-- </div>
      </div>
    </div> -->
  </footer><!-- End Footer -->

  <!-- <div id="preloader"></div> -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/vendor/purecounter/purecounter.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>
  <script src="{{asset('assets/vendor/slick/common.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

  <script>
    var mySwiper = new Swiper('.swiper-container', {
      loop: true,
      slidesPerView: 3,
      spaceBetween: 10,
      centeredSlides: true,
      pagination: '.swiper-pagination',
      nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev'
    })
  </script>

  <!-- Additon when renewal -->
  <script src="{{asset('assets/js/renewal.js')}}"></script>

  @yield('script')

  <!-- pickadate.js
  <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
  <script src="{{asset('assets/js/picker-main.js')}}"></script>
  <script src="{{asset('assets/js/legacy.js')}}"></script>
  <script src="{{asset('assets/js/picker.date.js')}}"></script>
  <script src="{{asset('assets/js/picker.js')}}"></script>
  <script src="{{asset('assets/js/picker.time.js')}}"></script>
  <script src="{{asset('assets/js/ja_JP.js')}}"></script> -->

</body>

</html>