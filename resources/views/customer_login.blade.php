@extends('layouts.app_nav1')

@section('content')
<!-- ======= Hero_about Section ======= -->
<section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お客様ログイン</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <form class="d-block mx-auto w-75" method="POST" action="/customercheckin/set_reserve_num">
                @csrf
                <div class="form-group">
                  <h2 class="bold">予約番号</h2>
                  @if(isset($err))
                  <h3 class="bold text-red">{{$err}}</h3>
                  @endif
                  @error('reservation_num')
                  <h5 class="error_text">{{$message}}</h5>
                  @enderror
                  <input class="form-control" type="text" name="reservation_num">
                </div>
                <button type="submit" class="btn btn-primary mt-3">次へ</button>
            　</form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection