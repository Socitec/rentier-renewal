@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">予約申し込み完了画面</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              @if(isset($err_message))
              <h3 class="text-red">{{$err_message}}</h3>
              @endif
              <h2 class="comp mx-auto">　ご予約いただきありがとうございます。予約が完了いたしました。<br><br></h2>
              <h2 class="comp mx-auto">ご予約に使用されたメールアドレス宛に確認のメールを送付させていただきましたのでご確認お願い致します。迷惑メールに入っている可能性もございますので迷惑メールフォルダもご確認お願い致します。</h2>
              <a class="comp2 btn btn-primary text-white rounded-pill bold wide90 mt-5" href="{{url('/')}}">トップページへ戻る</a>
              <a class="comp2 btn btn-primary text-white rounded-pill bold wide90 mt-5" href="{{url('/rooms')}}">お部屋一覧へ戻る</a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection