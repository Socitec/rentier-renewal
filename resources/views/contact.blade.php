<?php
//物件詳細ページの物件名を問い合わせ内容に初期表示する
$contentText = "{$property['name']}について";
?>

@extends('layouts/app_nav4')

@section('content')
<!-- ======= Heading Section ======= -->
<section id="" class="c_heading-section">
  <div class="container c_container c_heading-container">
    <h1 class="c_heading-text" id="property_name">
      お問い合わせフォーム
    </h1>
  </div>
</section>
<!-- End Heading Section -->

<main id="main">

  <!-- ======= Contact Section ======= -->
  <section class="contact__section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 mx-auto contact__wrapper">
          <form action="/contact_send" method="POST">
            <div class="contact__box">
              @csrf
              <div class="contact__item--underline contact__item--purpose">
                <table class="mt-4">
                  <tr>
                    <th>
                      <h2 class="contact__property">お問い合わせの目的</h2>
                    </th>
                    <th>
                      <p class="contact_require">必須</p>
                    </th>
                    @error('checkbox')
                    <th>
                      <h5 class="error_text">{{$message}}</h5>
                    </th>
                    @enderror
                  </tr>
                </table>
              </div>
              <div class="contact__item--underline contact__item-purpose-checkbox">
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="宿泊について" checked class="mt-2 input">
                  <span class="text contact__checkbox-item">宿泊について</span>
                </label>
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="時間レンタルについて" class="mt-2 input">
                  <span class="text contact__checkbox-item">時間レンタルについて</span>
                </label>
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="長期滞在について" class="mt-2 input">
                  <span class="text contact__checkbox-item">長期滞在について</span>
                </label>
                <br>
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="土地・物件見学" class="mt-2 input">
                  <span class="text contact__checkbox-item">土地・物件見学</span>
                </label>
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="土地・物件問い合わせ" class="mt-2 input">
                  <span class="text contact__checkbox-item">土地・物件問い合わせ</span>
                </label>
                <label>
                  <input type="checkbox" id="inquiry_items" name="checkbox" value="その他" class="mt-2 input">
                  <span class="text contact__checkbox-item">その他</span>
                </label>
              </div>
              <div class="contact__item--underline">
                <table class="mt-4">
                  <tr>
                    <th>
                      <h2 class="contact__property">お名前（漢字）</h2>
                    </th>
                    <th>
                      <p class="contact_require">必須</p>
                    </th>
                    @error('name')
                    <th>
                      <h5 class="error_text">{{$message}}</h5>
                    </th>
                    @enderror
                  </tr>
                </table>
                <input type="text" class="form-control mt-2 @error('name') is-invalid @enderror contact__input-text" id="name" name="name">
              </div>
              <div class="contact__item--underline">
                <table class="mt-4">
                  <tr>
                    <th>
                      <h2 class="contact__property">お名前（カタカナ）</h2>
                    </th>
                  </tr>
                </table>
                <input type="text" class="form-control mt-2 contact__input-text" id="name_kana" name="name_kana">
              </div>
              <div class="contact__item--underline">
                <table class="mt-4">
                  <tr>
                    <th>
                      <h2 class="contact__property">Email</h2>
                    </th>
                    <th>
                      <p class="contact_require">必須</p>
                    </th>
                    @error('email')
                    <th>
                      <h5 class="error_text">{{$message}}</h5>
                    </th>
                    @enderror
                  </tr>
                </table>
                <input type="text" class="form-control mt-2 @error('email') is-invalid @enderror contact__input-text" id="email" name="email">
              </div>
              <div class="contact__item--underline">
                <table class="mt-4">
                  <tr>
                    <th>
                      <h2 class="contact__property">電話番号</h2>
                    </th>
                    <th>
                      <p class="contact_require">必須</p>
                    </th>
                    @error('telphone')
                    <th>
                      <h5 class="error_text">{{$message}}</h5>
                    </th>
                    @enderror
                  </tr>
                </table>
                <input type="text" class="form-control mt-2 @error('telphone') is-invalid @enderror contact__input-text" id="telphone" name="telphone">
              </div>
              <table class="mt-4 contact__content-table">
                <tr>
                  <th>
                    <h2 class="contact__property contact__property--content">お問い合わせ内容</h2>
                  </th>
                  <th>
                    <p class="contact_require">必須</p>
                  </th>
                  @error('contact')
                  <th>
                    <h5 class="error_text">{{$message}}</h5>
                  </th>
                  @enderror
                </tr>
              </table>
              <textarea type="text" class="form-control mt-2 h200 @error('contact') is-invalid @enderror" id="contact" name="contact" >{{$contentText}}</textarea>
            </div>
            <div class="text-center mt-5">
              <input type="submit" class="btn text-white rounded-pill bold contact__input-submit" value="送信">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->

  <!-- ======= Pagenation Section ======= -->
  <section class="c_list-paganation-section">
    <div class="container c_container c_list-paganation-container">
      <div class="c_list-pagenation-top-box">
        <a href="#" onclick="history.back()" class="c_list-pagenation-top-link">
          <img class="c_list-pagenation-bouble-arrow-icon" src="{{asset('assets/img/double-arrow-left_icon.svg')}}" alt="top">
          <p class="c_list-pagenation-top-text">
            Back
          </p>
        </a>
      </div>
    </div>
  </section>
  <!-- End Pagenation Section -->

</main><!-- End #main -->
@endsection