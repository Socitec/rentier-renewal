@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero_rooms" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お部屋予約確定</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Rooms Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <h1>お部屋予約確定</h1>
            <h3>予約が完了いたしました。この度はご予約いただきありがとうございます。</h3>
            <div class="text-center mt-5">
                <a class="btn btn-primary" href="{{url('/')}}">トップページに戻る</a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Rooms Section -->

  </main><!-- End #main -->
@endsection