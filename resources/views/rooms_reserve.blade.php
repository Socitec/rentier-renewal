@extends('layouts/app_nav3')

@section('style')
<style>
  .table>:not(caption)>*>* {
    border-bottom-width: 0px !important;
  }
</style>
@endsection

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">予約申し込み</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <h2>予約申し込みを行うと、登録したメールアドレスに予約URLのメールが届きます。</h2>
              @if (isset($err_message))
              <h6 class="bold text-red">{{$err_message}}</h6>
              @endif
            </div>
            
            @yield('alert')

            <form action="/stay_reseve_send" method="POST" name="form1">
              @csrf
              @if(isset($get_query))
              <input type="hidden" class="full_width mt-2 @error('name') is-invalid @enderror" max="100" id="name" name="name" value="{{$get_query->name}}">
              @else
              <input type="hidden" class="full_width mt-2 @error('name') is-invalid @enderror" max="100" id="name" name="name" value="{{$name}}">
              @endif
              @if(isset($get_query))
              <input type="hidden" class="full_width mt-2 @error('email') is-invalid @enderror" max="50" id="email" name="email" value="{{$get_query->email}}">
              @else
              <input type="hidden" class="full_width mt-2 @error('email') is-invalid @enderror" max="50" id="email" name="email" value="{{$mail}}">
              @endif
              <table class="mt-4">
                <tr>
                  <th><h2>電話番号</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('telphone')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <p class="text-red bold">※電話番号はハイフンなしの半角数字で入力をお願い致します。</p>
              @if(isset($get_query))
              <input type="text" class="full_width mt-2 mt-2 @error('tel') is-invalid @enderror" id="tel" name="tel" value="{{$get_query->tel}}">
              @else
              <input type="text" class="full_width mt-2 mt-2 @error('tel') is-invalid @enderror" id="tel" name="tel">
              @endif
              <table class="mt-4">
                <tr>
                  <th><h2>ご利用人数</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('stay_people')
                  <th><h5 class="error_text">{{$message}}</h5></th> 
                  @enderror
                </tr>
              </table>
              @if(isset($get_query))
              <input type="text" class="full_width mt-2 @error('stay_people') is-invalid @enderror" max="100" id="stay_people" name="stay_people" value="{{$get_query->stay_people}}">
              @else
              <input type="text" class="full_width mt-2 @error('stay_people') is-invalid @enderror" max="100" id="stay_people" name="stay_people">
              @endif
              
              @yield('schedule')

              <input name="room_id" type="hidden" value="{{$room_id}}">
              <table class="table mt-4">
                <tr>
                  <th class="no_border"><a class="btn btn-primary" href="{{url('/terms_of_use')}}" target="_blank">利用規約</a></th>
                  <td class="no_border"><span>利用規約を確認する</span></td>
                </tr>
                <tr>
                  <th class="no_border"><a class="btn btn-primary" href="{{url('/privacy_policy')}}" target="_blank">プライバシーポリシー</a></th>
                  <td class="no_border"><span>プライバシーポリシーを確認する</span></td>
                </tr>
                <tr>
                  <th class="no_border"><a class="btn btn-primary" href="{{url('/cancel_policy')}}" target="_blank">キャンセルポリシー</a></th>
                  <td class="no_border"><span>キャンセルポリシーを確認する</span></td>
                </tr>
              </table>
              <label for="accept">
                <input type="checkbox" require class="input" id="accept">
                <span class="text">私は、利用規約とプライバシーポリシー、キャンセルポリシーを確認し、同意のうえで申し込みします。</span>
              </label>
              <div class="text-center"><span class="text-red">※利用規約とプライバシーポリシー、キャンセルポリシーに同意しなければ送信ボタンは表示されません。</span></div>
              <div class="text-center mt-5" id="confirm">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection