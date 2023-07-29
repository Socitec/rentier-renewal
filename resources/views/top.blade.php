@extends('layouts/app_nav1')

@section('content')
<!-- 2023年7月リニューアルここから -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <div class="container">
    <h1 class="ml3vw font-5">
      貸りる。泊まる。<br>
      買う。<br>
      ぜんぶ、レンティアで
    </h1>
    <h2>
      デモサイト
    </h2>
    <a href="{{url('/about')}}" class="btn-get-started scrollto ml3vw none">about</a>
  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- slide -->
  <div class="sliderArea mt-5">
    <div class="slide01 slider">
      @foreach($top_sliders as $top_slider)
      <div><a href="{{url('room_detail',['room_id' => $top_slider->id])}}"><img src="{{$top_slider->image_pass}}" alt="top_slider"></a></div>
      @endforeach
      @foreach($top_sliders as $top_slider)
      <div><a href="{{url('room_detail',['room_id' => $top_slider->id])}}"><img src="{{$top_slider->image_pass}}" alt="top_slider"></a></div>
      @endforeach
      @foreach($top_sliders as $top_slider)
      <div><a href="{{url('room_detail',['room_id' => $top_slider->id])}}"><img src="{{$top_slider->image_pass}}" alt="top_slider"></a></div>
      @endforeach
    </div>
  </div>

  <!-- ======= Howto Section ======= -->
  <section class="top__howto_section">
    <div class="container">
      <div class="top__heading-area">
        <p class="top__heading-toptext">
          レンティアの使い方
        </p>
        <h2 class="top__heading-maintext">
          How to use <span class="top__heading-toptext--bold">RENTIER</span>
        </h2>
      </div>
      <div class="top__bar-area">
        <div class="top__bar-item"></div>
      </div>
      <div class="top__howto-box">
        <div class="top__howto-item">
          <h3 class="top__howto-heading-text">
            レンタルスペース
          </h3>
          <img class="top__howto-img" src="{{asset('assets/img/index_howto_rental.png')}}" alt="rental">
          <p class="top__howto-description-text">
            使いたい時に使いたい時間だけ！<br>
            ワークスペースとして、<br>
            パーティールームとしても<br>
            ご利用いただけます。
          </p>
        </div>
        <div class="top__howto-item">
          <h3 class="top__howto-heading-text">
            宿泊
          </h3>
          <img class="top__howto-img" src="{{asset('assets/img/index_howto_stay.png')}}" alt="stay">
          <p class="top__howto-description-text">
            宿泊も可能です。<br>
            パーティー後そのまま宿泊、<br>
            旅行で滞在等、<br>
            お気軽にご相談ください。
          </p>
        </div>
        <div class="top__howto-item">
          <h3 class="top__howto-heading-text">
            長期滞在
          </h3>
          <img class="top__howto-img" src="{{asset('assets/img/index_howto_longstay.png')}}" alt="longstay">
          <p class="top__howto-description-text">
            長期での滞在もお受けしております。<br>
            長期利用の場合には<br>
            割引サービスもございます。
          </p>
        </div>
        <div class="top__howto-item">
          <h3 class="top__howto-heading-text">
            物件・土地を購入する
          </h3>
          <img class="top__howto-img" src="{{asset('assets/img/index_howto_property.png')}}" alt="property">
          <p class="top__howto-description-text">
            新しく家を購入したい。<br>
            家を建てる土地が欲しい。<br>
            そんな方にも穴場の物件・土地が<br>
            見つかるかもしれません。
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End Howto Section -->

  <!-- ======= Land and Property Section ======= -->
  <section class="top__landProperty-section">
    <div class="container">
      <div class="top__heading-area">
        <p class="top__heading-toptext">
          人気の物件
        </p>
        <h2 class="top__heading-maintext">
          Popular <span class="top__heading-toptext--bold">Property</span>
        </h2>
      </div>
      <div class="top__bar-area">
        <div class="top__bar-item"></div>
      </div>
      <div class="top__slide-area">
        <div class="top__slide-box">
          <div class="swiper">
            <!-- 必要に応じたwrapper -->
            <div class="swiper-wrapper">
              <!-- スライド -->
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
            </div>
            <!-- 必要に応じてページネーション -->
            <div class="swiper-pagination"></div>
            <!-- 必要に応じてナビボタン -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Land and Property Section -->

  <!-- ======= Land and Property Section ======= -->
  <section class="top__rooms-section">
    <div class="container">
      <div class="top__heading-area">
        <p class="top__heading-toptext">
          人気のお部屋
        </p>
        <h2 class="top__heading-maintext">
          Popular <span class="top__heading-toptext--bold">Room</span>
        </h2>
      </div>
      <div class="top__bar-area">
        <div class="top__bar-item"></div>
      </div>
      <div class="top__slide-area">
        <div class="top__slide-box">
          <div class="swiper top__slide">
            <!-- 必要に応じたwrapper -->
            <div class="swiper-wrapper">
              <!-- スライド -->
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
              <div class="swiper-slide"><a href=""><img class="top__swiper-item-img" src="{{asset('assets/img/dummy_room.png')}}" alt="property"></a></div>
            </div>
            <!-- 必要に応じてページネーション -->
            <div class="swiper-pagination"></div>
            <!-- 必要に応じてナビボタン -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Land and Property Section -->

  <!-- 2023年7月リニューアルここまで -->

  <!-- ======= Covid-19 Section ======= -->
  <!-- <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 d-flex align-items-stretch mx-auto">
          <a href="{{url('/covid_19')}}">
            <img class="size" src="{{asset('assets/img/index_covid_19.PNG')}}" alt="about_covid_19">
          </a>
        </div>
      </div>
    </div>
  </section>  -->
  <!-- End Covid-19 Section -->

  <!-- ======= Example Section ======= -->
  <!-- <section>
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
        <div class="text-center mt-5">
          <a class="btn btn-primary text-white rounded-pill bold wide60" href="{{url('/about')}}">予約の流れについて</a>
        </div>
      </div>
    </div>
  </section> -->
  <!-- End Example Section -->

  <!-- ======= Place Section ======= -->
  <!-- <section>
    <div class="container">
      <div class="row col-lg-7 col-md-7 mx-auto">
        <div class="text-center">
          <h2>場所から選ぶ</h2>
        </div>
        <div class="col-md-6 col-lg-6 align-items-center mt-3">
          <a href="{{url('/rooms/愛知県')}}">
            <img class="size" src="{{asset('assets/img/index_aichi_prefecture.PNG')}}" alt="aichi">
          </a>
        </div>
        <div class="col-md-6 col-lg-6 align-items-center mt-3">
          <a href="{{url('/rooms/福岡県')}}">
            <img class="size" src="{{asset('assets/img/index_fukuoka_prefecture.PNG')}}" alt="fukuoka">
          </a>
        </div>
      </div>
    </div>
  </section> -->
  <!-- End Place Section -->

  <!-- ======= Rooms Section ======= -->
  <!-- <section>
    <div class="container">
      <div class="row col-lg-9 col-md-9 mx-auto">
        <div class="text-center">
          <h2>人気のお部屋</h2>
        </div>
        @foreach($top_rankings as $top_ranking)
        <?php
        // 整形したい文字列
        $text = $top_ranking->stay_name;
        // 文字数の上限
        $limit = 30;

        if (mb_strlen($text) > $limit) {
          $title = mb_substr($text, 0, $limit);
          $title .= "....";
        }
        ?>
        <div class="col-md-4 col-lg-4">
          <div class="align-items-center">
            <a href="{{url('room_detail', ['room_id' => $top_ranking->room_id])}}">
              <img class="size" src="{{asset($top_ranking->room_list_image)}}" alt="room">
            </a>
          </div>
          <p class="bold">{{$title}}</p>
        </div>
        @endforeach
        <div class="text-center mt-5">
          <a class="btn btn-primary text-white rounded-pill bold wide90" href="{{url('/rooms')}}">部屋一覧へ</a>
        </div>
      </div>
    </div>
  </section> -->
  <!-- End Rooms Section -->

</main><!-- End #main -->
@endsection