@extends('layouts.app_nav2')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_about" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">土地一覧</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
                <h2>レンティアとは</h2>
            </div>
            <p class="mt-5">レンティアはこれまでのレンタルスペースとは違い、レンタルスペースと宿泊施設が合わさった、これまでにない新しいサービスです。<br>
            一般的なレンタルスペースは、宿泊業の許可を得ていないため宿泊をすることは不可能でした。レンティアが運営するお部屋は民泊として営業している部屋ばかりですので、このサービスが実現できました。<br>
            「周りを気にせず気兼ねなく話したい女子会に！」「終電を気にせず楽しみたい！」そんなニーズに応えるべく、宿泊も可能なレンタルスペースとしてサービス展開をしています。<br>
            パーティールーム、急な出張や旅行など、さまざまなシーンに応じてフレキシブルにご利用いただけます。</p>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->

    <!-- ======= Example Section ======= -->
    <section>
      <div class="container">
        <div class="row col-md-9 col-lg-9 mx-auto">
          <div class="text-center">
            <h2>活用事例</h2>
          </div>
          <div class="col-md-4 col-lg-4">
            <div class="align-items-center">
              <img class="size" src="{{asset('assets/img/index_drinks.png')}}" alt="drinks">
            </div>
            <div class="text-center mt-2">
              <h3>レンタルスペース</h3>
            </div>
            <p class="mt-2">使いたい時に使いたい時間だけ！ワークスペースとして、パーティールームとしてっもご利用いただけます。</p>
          </div>
          <div class="col-md-4 col-lg-4">
            <div>
              <img class="size" src="{{asset('assets/img/index_pillows.png')}}" alt="pillows">
            </div>
            <div class="text-center mt-2">
              <h3>宿泊</h3>
            </div>
            <p class="mt-2">宿泊も可能です。パーティー後そのまま宿泊、旅行で滞在等、お気軽にご相談ください。</p>
          </div>
          <div class="col-md-4 col-lg-4">
            <div>
              <img class="size" src="{{asset('assets/img/index_coffee.png')}}" alt="coffee">
            </div>
            <div class="text-center mt-2">
              <h3>長期滞在</h3>
            </div>
            <p class="mt-2">長期での滞在もお受けしております。長期利用の場合には割引サービスもございます。</p>
          </div>
        </div>
      </div>
    </section>
    <!-- End Example Section -->

    <!-- ======= Reserve Section ======= -->
    <section>
      <div class="container">
        <div class="row col-lg-8 col-md-8 mx-auto">
          <div class="text-center">
            <h2>予約フロー</h2>
          </div>
          <table class="flow">
            <tr>
              <th class="flow-left text-white"><h2 class="p-3">1</h2></th>
              <th class="flow-right bold">確認メールのリンクより予約フォームにて申し込み</th>
            </tr>
          </table>
          <div class="text-center mt-2">
              <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
          </div>
          <table class="flow mt-2">
            <tr>
              <th class="flow-left text-white"><h2 class="p-3">2</h2></th>
              <th class="flow-right bold">リンク先のフォームにて必要事項を入力</th>
            </tr>
          </table>
          <div class="text-center mt-2">
              <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
          </div>
          <table class="flow mt-2">
            <tr>
              <th class="flow-left text-white"><h2 class="p-3">3</h2></th>
              <th class="flow-right bold">ご利用料金のお支払い</th>
            </tr>
          </table>
          <div class="text-center mt-2">
              <img src="{{asset('assets/img/about_next_flow.PNG')}}" alt="next-flow">
          </div>
          <table class="flow mt-2">
            <tr>
              <th class="flow-left text-white"><h2 class="p-3">4</h2></th>
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