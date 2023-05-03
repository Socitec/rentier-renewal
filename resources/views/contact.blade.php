@extends('layouts/app_nav4')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お問い合わせ</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <h2>部屋のご予約は各ページからお申し込みください。</h2>
            </div>
            <form action="/contact_send" method="POST">
              @csrf
              <table class="mt-4">
                <tr>
                  <th><h2>名前</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('name')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>   
              </table>
              <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror" id="name" name="name">
              <table class="mt-4">
                <tr>
                  <th><h2>Email</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('email')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>

              <input type="text" class="form-control mt-2 @error('email') is-invalid @enderror" id="email" name="email">
              <table class="mt-4">
                <tr>
                  <th><h2>電話番号</h2></th>  
                  <th><p class="contact_require">必須</p></th>
                  @error('telphone')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" class="form-control mt-2 @error('telphone') is-invalid @enderror" id="telphone" name="telphone">
              <table class="mt-4">
                <tr>
                  <th><h2>お問い合わせ項目</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('checkbox')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <label>
                <input type="checkbox" id="inquiry_items" name="checkbox" value="宿泊について" checked class="mt-2 input">
                <span class="text">宿泊について</span>
              </label>
              <label>
                <input type="checkbox" id="inquiry_items" name="checkbox" value="時間レンタルについて" class="mt-2 input">
                <span class="text">時間レンタルについて</span>
              </label>
              <label>
                <input type="checkbox" id="inquiry_items" name="checkbox" value="長期滞在について" class="mt-2 input">
                <span class="text">長期滞在について</span>
              </label>
              <label>
                <input type="checkbox" id="inquiry_items" name="checkbox" value="その他" class="mt-2 input">
                <span class="text">その他</span>
              </label>
              <table class="mt-4">
                <tr>
                  <th><h2>お問い合わせ内容</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('contact')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input type="text" class="form-control mt-2 h200 @error('contact') is-invalid @enderror" id="contact" name="contact">
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