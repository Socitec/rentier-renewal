@extends('layouts/app_nav4')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お問い合わせ完了</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <h1>キャンセルの情報を運営に送信しました。</h1>
            <h3 class="mt-5">レンティア運営側で確認させて頂きます。キャンセル処理後メールにて確認メールを送信させて頂きます。</h3>
            <div class="text-center">
                <a class="btn btn-primary mt-5" href="{{url('/')}}">トップページに戻る</a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection