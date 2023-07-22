@extends('layouts.app_nav2')

@section('content')
<!-- ======= Heading Section ======= -->
<section id="" class="c_heading-section">
  <div class="container c_heading-container">
    <h1 class="c_heading-text">
      土地情報一覧
    </h1>
    <p class="c_heading-subtext">
      Land
    </p>
  </div>
</section>
<!-- End Heading Section -->

<main class="c_main" id="main">
  <section class="c_filter-section">
    <!-- 確認：フィルター機能ははじめは実装しない -->
    <a>
      <p class="c_filter-text">
        <img class="c_filter-icon" src="{{asset('assets/img/triangle-right_icon.svg')}}" alt="next">
        エリアで絞り込む
      </p>
    </a>
  </section>

  <!-- ======= List Section ======= -->
  <section class="c_list-section">

    <!-- backEnd: ここから複製 -->
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <!-- backEnd: 複製ここまで -->

    <!-- ここからダミー -->
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <div class="container c_list-container">
      <div class="c_list-box">
        <img class="c_property-img" src="{{asset('assets/img/dummy_property-thumbnail.jpg')}}" alt="property">
        <p class="c_list-description-text">
          土地の情報がここに入ります。<br>
          土地の情報がここに入ります。
        </p>
      </div>
    </div>
    <!-- ダミーここまで -->

  </section>
  <!-- End List Section -->

  <!-- ======= Pagenation Section ======= -->
  <section class="c_list-paganation-section">
    <div class="container c_list-paganation-container">
      <div class="c_list-pagenation-top-box">
        <a href="" class="c_list-pagenation-top-link">
          <img src="{{asset('assets/img/double-arrow-left_icon.svg')}}" alt="top">
          <p class="c_list-pagenation-top-text">
            Top
          </p>
        </a>
      </div>
      <div class="c_list-pagenation-page-box">
        <div class="c_list-pagenation-prev-item">
          <a href="" class=""></a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Pagenation Section -->

  <!-- ======= Reserve Section ======= -->
  <section>
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
  </section><!-- End Reserve Section -->

  <!-- ======= Attentions Section ======= -->
  <section>
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
  </section>
  <!-- End Attentions Section -->

</main><!-- End #main -->
@endsection