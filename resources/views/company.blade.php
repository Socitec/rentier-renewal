@extends('layouts.app_nav1')

@section('content')
<!-- ======= Heading Section ======= -->
<section id="" class="c_heading-section">
  <div class="container c_container c_heading-container">
    <h1 class="c_heading-text" id="property_name">
      会社概要
    </h1>
  </div>
</section>
<!-- End Heading Section -->

<main class="c_main" id="main">

  <!-- ======= Company Detail Section ======= -->
  <section class="company__detail-section">
    <div class="container company__detail-container">
      <div class="company__detail-box">
        <div class="company__detail-row-item">
          <p class="company__detail-property-text">
            会社名
          </p>
          <p class="company__detail-value-text">
            Ito Business Office合同会社
          </p>
        </div>
        <div class="company__detail-row-item">
          <p class="company__detail-property-text">
            代表
          </p>
          <p class="company__detail-value-text">
            伊藤 詩織
          </p>
        </div>
        <div class="company__detail-row-item">
          <p class="company__detail-property-text">
            所在地
          </p>
          <p class="company__detail-value-text">
            <img class="company__detail-address" src="{{asset('assets/img/address_company.png')}}" alt="property">
          </p>
        </div>
        <div class="company__detail-row-item">
          <p class="company__detail-property-text">
            TEL
          </p>
          <p class="company__detail-value-text">
            050-5435-9874
          </p>
        </div>
        <div class="company__detail-row-item">
          <p class="company__detail-property-text">
            Mail
          </p>
          <p class="company__detail-value-text">
            dreamjourney37ibo▲gmail.com （▲を@に置き換えてください）
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End List Section -->

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