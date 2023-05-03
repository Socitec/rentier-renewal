@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">管理者画面</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <a class="btn btn-primary mt-5" href="{{action('\App\Http\Controllers\Admin_Reserve_Controller@stay')}}">宿泊予約の作成へ</a>
              <a class="btn btn-primary mt-5" href="{{action('\App\Http\Controllers\Admin_Reserve_Controller@time')}}">時間貸し予約の作成へ</a>
              <a class="btn btn-danger mt-5" href="{{action('\App\Http\Controllers\Admin_Reserve_Controller@delete')}}">予約の取り消しへ</a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection