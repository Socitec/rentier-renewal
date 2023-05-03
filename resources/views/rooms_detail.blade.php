@extends('layouts/app_nav3')

@section('style')
<link href="{{asset('assets/vendor/slick/rooms_detail.css')}}" rel="stylesheet">
@endsection

@section('content')
<main id="main">

<!-- ======= Detail Section ======= -->
<section class="room_detail">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 mx-auto">
        <h2>{{$room_detail->stay_name}}</h2>
        <!-- slide -->
        <div class="sliderArea mt-5">
          <div class="slide02 slider">
            <div><img class="size" src="{{asset($room_detail_slider->image_pass1)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass2)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass3)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass4)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass5)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass6)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass7)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass8)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass9)}}" alt="room_detail"></div>
            <div><img class="size" src="{{asset($room_detail_slider->image_pass10)}}" alt="room_detail"></div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-lg-7 mt-5">
                <h2>説明</h2>
                {!! $room_detail->comment !!}
                <h2 class="mt-5">料金</h2>
                <li class="inline">￥{{$room_detail->h_price}}/h</li>
                <li class="inline">￥{{$room_detail->day_price}}/泊</li>
                <h2 class="mt-5">利用人数</h2>
                <span>6人</span>
            </div>
            <div class="col-md-5 col-lg-5 mt-5">
                <h2>アメニティ・サービス</h2>
                <table class="table">
                    <?php $count = 0; ?>
                    @foreach($amenitie_num as $amenitie)
                    @if($count == 0 )
                    <tr>
                        <td>・{{$amenitie->amenitie}}</td>
                        <?php $count++; ?>
                    @if($loop->last)
                    </tr>
                    @endif
                    @elseif($count == 1)
                        <td>・{{$amenitie->amenitie}}</td>
                        <?php $count = 0; ?>
                    </tr>
                    @endif
                    @endforeach

                </table>     
            </div>
        </div>
        <table>
          <tr>
            <td><h2 class="mt-5">アクセス</h2></td>
            <td><p class="pt-5">※詳しい住所、部屋番号は決済後にお知らせいたします。</p></td>
          </tr>
        </table>
        <div class="align-items-center">
          @if($id==6)
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d244.17640239061595!2d136.9456441070167!3d35.166642154526365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x600371ac0d277c27%3A0xab496f4663c8bc5b!2z5rGg5LiL44OI44O844Ob44O844OT44Or!5e0!3m2!1sja!2sjp!4v1637128175827!5m2!1sja!2sjp" frameborder="0" scrolling="no" width="100%" height="400"></iframe>
          @else
          <iframe class="gmap" src="https://maps.google.co.jp/maps?output=embed&t=m&hl=ja&z=18&ll={{$lat}},{{$lng}}&q={{$lat}},{{$lng}}" frameborder="0" scrolling="no" width="100%" height="400"></iframe>
          @endif
        </div>
        <p class="mt-5">
        @foreach($room_access as $access)
          {{$access->acces_text}}<br> 
        @endforeach
        <a class="btn btn-primary full_width p-3 mt-5 bold" href="{{url('/roomsreserve_stay_mail_check', ['room_id' => $room_detail->id])}}">宿泊で予約をする</a>
        <a class="btn btn-primary full_width p-3 mt-5 bold" href="{{url('/roomsreserve_time_mail_check', ['room_id' => $room_detail->id])}}">時間貸しで予約をする</a>
      </div>
    </div>
  </div>
</section><!-- End Detail Section -->

</main><!-- End #main -->
@endsection