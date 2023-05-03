@extends('layouts/app')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">確認メール</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <h2>部屋を時間貸し予約する際に、入力フォームに確認メールを送信してください</h2>
            </div>
            <form action="/time_mail_check" method="POST" enctype="multipart/form-data" name="form1">
              @csrf
              <table class="mt-4">
                <tr>
                  <th><h2>Email</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('email')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" class="full_width mt-2 @error('email') is-invalid @enderror" id="email" name="email">
              <table class="mt-4">
                <tr>
                  <th><h2>名前</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('user_name')
                  <th><h5 class="error_text">{{$message}}</h5></th> 
                  @enderror
                </tr>
              </table>
              <input type="text" class="full_width mt-2 @error('user_name') is-invalid @enderror" id="user_name" name="user_name">                          
              <input type="hidden" name="room_id" value="{{$room_id}}">
              @if(isset($mail_miss))
              @if($mail_miss == true)
              <div class="text-center mt-5 error_text">
              <h4>メール送信失敗しました。<br>もう一度送るか、メールアドレスを変えて送信してください。</h4>
              </div>
              @endif
              @endif
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