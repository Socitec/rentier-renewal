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
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
  
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="{{url('/')}}"><img src="{{asset('assets/img/logo.png')}}" alt="logo"></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      @yield('nav')

    </div>
  </header><!-- End Header -->

  <!-- コンテンツの処理を実行 -->
  @yield('content')

  <!-- ======= Footer ======= -->
  <footer class="footer-bg">

      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto text-center">
            <ul class="text-white">
              <li class="inline"><a href="{{url('/')}}">ホーム</a></li>
              <li class="inline"><a href="{{url('/about')}}">はじめての方</a></li>
              <li class="inline"><a href="{{url('/rooms')}}">お部屋一覧</a></li>
              <li class="inline"><a href="{{url('/privacy_policy')}}">プライバシーポリシー</a></li>
              <li class="inline"><a href="{{url('/terms_of_use')}}">利用規約</a></li>
              <li class="inline"><a href="{{url('/contact')}}">お問い合わせ</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="text-center">
        <div class="copyright">
          &copy; Copyright <strong><span>Ito Business Office LLC</span></strong> All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
          <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
        </div>
      </div>
    </div>
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
    var mySwiper = new Swiper ('.swiper-container', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 10,
        centeredSlides : true,
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
      })
  </script>

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