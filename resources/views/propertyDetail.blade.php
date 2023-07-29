@extends('layouts.app_nav2')

@section('content')
<!-- ======= Heading Section ======= -->
<section id="" class="c_heading-section">
  <div class="container c_container c_heading-container">
    <h1 class="c_heading-text" id="property_name">
      ここに物件の名前が入ります
    </h1>
  </div>
</section>
<!-- End Heading Section -->

<main class="c_main" id="main">

  <!-- ======= Detail Section ======= -->
  <section class="c_detail-section">
    <div class="container c_detail-container">
      <div class="c_detail-slider-box">
        <div class="detail_swiper">
          <!-- 必要に応じたwrapper -->
          <div class="swiper-wrapper">
            <!-- スライド -->
            <div class="swiper-slide"><img class="c_detail-slider-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></div>
            <div class="swiper-slide"><img class="c_detail-slider-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></div>
            <div class="swiper-slide"><img class="c_detail-slider-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></div>
            <div class="swiper-slide"><img class="c_detail-slider-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></div>
          </div>
          <!-- 必要に応じてページネーション -->
          <div class="swiper-pagination"></div>
          <!-- 必要に応じてナビボタン -->
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
      <div class="c_detail-description-box">
        <p class="c_detail-description-text">
          ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。<br>
          ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。<br>
          ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。<br>
          ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。ここに説明が入ります。
        </p>
      </div>
      <div class="c_detail-specification-box">
        <div class="c_detail-specification-double-wrapper">
          <div class="c_detail-specification-single-item">
            <p class="c_detail-specification-property-text">
              販売価格
            </p>
            <p class="c_detail-specification-value-text">
              0,000万円
            </p>
          </div>
          <div class="c_detail-specification-single-item">
            <p class="c_detail-specification-property-text">
              間取り
            </p>
            <p class="c_detail-specification-value-text">
              3LDK
            </p>
          </div>
        </div>
        <div class="c_detail-specification-double-wrapper">
          <div class="c_detail-specification-single-item">
            <p class="c_detail-specification-property-text">
              延床面積
            </p>
            <p class="c_detail-specification-value-text">
              00.00坪
            </p>
          </div>
          <div class="c_detail-specification-single-item">
            <p class="c_detail-specification-property-text">
              エリア
            </p>
            <p class="c_detail-specification-value-text">
              〇〇県〇〇市
            </p>
          </div>
        </div>
        <div class="c_detail-specification-single-item">
          <p class="c_detail-specification-property-text">
            沿線・最寄り駅
          </p>
          <p class="c_detail-specification-value-text">
            〇〇線／〇〇駅
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End List Section -->

  <!-- ======= Button Section ======= -->
  <section class="c_button-section">
    <div class="c_button-container">
      <form class="c_detailForm" action="{{url('/contact')}}" method="POST">
        @csrf
        <input type="hidden" name="type" value="land" />
        <input type="hidden" name="name" value="【物件名】" />
        <input class="c_detail-contact-button" type="submit" name="submit" value="この物件に関してのお問い合わせ" />
      </form>
    </div>
  </section>
  <!-- End Button Section -->

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

  <!-- ======= Reserve Section ======= -->
  <!-- <section>
    <div class="container">
      <div class="row col-lg-8 col-md-8 mx-auto">
        <div class="text-center">
          <h2>予約フロー</h2>
        </div>
        <table class="flow">
          <tr>
            <th class="flow-left text-white">
              <h2 class="p-3">1</h2>
            </th>
            <th class="flow-right bold">確認メールのリンクより予約フォームにて申し込み</th>
          </tr>
        </table>
        <div class="text-center mt-2">
          <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
        </div>
        <table class="flow mt-2">
          <tr>
            <th class="flow-left text-white">
              <h2 class="p-3">2</h2>
            </th>
            <th class="flow-right bold">リンク先のフォームにて必要事項を入力</th>
          </tr>
        </table>
        <div class="text-center mt-2">
          <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
        </div>
        <table class="flow mt-2">
          <tr>
            <th class="flow-left text-white">
              <h2 class="p-3">3</h2>
            </th>
            <th class="flow-right bold">ご利用料金のお支払い</th>
          </tr>
        </table>
        <div class="text-center mt-2">
          <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
        </div>
        <table class="flow mt-2">
          <tr>
            <th class="flow-left text-white">
              <h2 class="p-3">4</h2>
            </th>
            <th class="flow-right bold">チェックイン(セルフチェックインとなります)</th>
          </tr>
        </table>
        <div class="text-center mt-5">
          <a class="btn btn-primary text-white rounded-pill bold wide90" href="{{url('rooms')}}">部屋一覧へ</a>
        </div>
      </div>
    </div>
  </section> -->
  <!-- End Reserve Section -->

  <!-- ======= Attentions Section ======= -->
  <!-- <section>
    <div class="container">
      <div class="row col-lg-8 col-md-8 mx-auto">
        <div class="text-center">
          <h3>注意事項</h3>
        </div>
        <p class="bold">次の利用者や近隣住民のために以下の点にご注意ください。<br>
          ・近隣には一般の入居者の方が住んでいます。大声、騒音等はご遠慮ください。<br>
          ・レンタルスペースとしてご利用の場合は、ゴミの持ち帰り、使用後の清掃を徹底してください。<br>
          ・レンタルスペースとしてご利用の場合は、寝具の使用はできません。寝具の使用が発覚した場合はクリーニング費用を請求する場合がありますので、ご注意ください。<br>
          ・飲食物、調理器具等の持ち込みは自由です。<br>
          ・備え付けの備品や設備に汚損や破損、盗難等が発覚した場合は実費ご請求いたします。<br>
          ・その他、利用規約に違反する行為が発覚した場合は、退室していただくとともに損害賠償請求をさせていただく場合もございます。</p>
      </div>
    </div>
  </section> -->
  <!-- End Attentions Section -->

</main><!-- End #main -->
@endsection