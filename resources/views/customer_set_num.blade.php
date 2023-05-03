@extends('layouts.app_nav1')

@section('content')
<!-- ======= Hero_about Section ======= -->
<section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">宿泊人数設定</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <form class="d-block mx-auto w-75" method="POST" action="/customercheckin/{{$reserve}}/set_user_num">
                @csrf
                <div class="form-group">
                　<h2 class="bold">利用人数</h2>
                  @error('user_num')
                  <h5 class="error_text">{{$message}}</h5>
                  @enderror
                　<input class="form-control" name="user_num" type="number" value="1" min="1" max="10" step="1">
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