@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">予約申し込み確認画面</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <h2>予約申し込みを行うと、登録したメールアドレスに予約URLのメールが届きます。以下の内容で予約を行いますか？</h2>
            </div>
            <form action="">
              @csrf
              <table class="mt-4">
                <tr>
                  <th><h2>名前</h2></th>
                  @error('user_name')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" readonly class="full_width mt-2 @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="test">
              <table class="mt-4">
                <tr>
                  <th><h2>Email</h2></th>
                  @error('email')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" readonly class="full_width mt-2 @error('email') is-invalid @enderror" id="email" name="email" value="test">
              <table class="mt-4">
                <tr>
                  <th><h2>電話番号</h2></th>
                  @error('telphone')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" readonly class="full_width mt-2 mt-2 @error('telphone') is-invalid @enderror" id="telphone" name="telphone" value="test">
              
              <table class="mt-4">
                <tr>
                  <th><h2>身分証明書(表面)</h2></th>
                  @error('id_card_front')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <img src="身分証明書表面画像のパス" alt="id_card_flont">
              
              <table class="mt-4">
                <tr>
                  <th><h2>身分証明書(裏面)</h2></th>
                  @error('id_card_back')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <img src="身分証明書裏面画像のパス" alt="id_card_back">

              <table class="mt-4">
                <tr>
                  <th><h2>予約日</h2></th>
                  @error('date')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" readonly class="full_width mt-2 mt-2 @error('date') is-invalid @enderror" id="date" name="date" value="2021-09-19">
              <table class="mt-4">
                <tr>
                  <th><h2>チェックイン</h2></th>
                  @error('checkin_time')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" readonly class="full_width mt-2 mt-2 @error('checkin_time') is-invalid @enderror" id="checkin_time" name="checkin_time" value="20:00">
              <div class="text-center mt-5">
                <input type="submit" class="btn btn-primary text-white rounded-pill bold wide90" value="送信する">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection