@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero_rooms" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お部屋一覧</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Rooms Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            @foreach($room_list  as $room)
            <div class="rooms p-2 mt-3">
              <a href="{{url('room_detail',['room_id' => $room->id])}}">
                <div class="row">  
                  <div class="col-md-5 col-lg-5 align-items-center">
                    <img class="size" src="{{asset($room->room_list_image)}}" alt="room_image">
                  </div>
                  <div class="col-md-7 col-lg-7">
                    <p class="bold text-black">{{$room->prefectures}}</p>
                    <h4 class="text-black">{{$room->title}}</h4>
                    
                    <ul class="options">
                    @foreach($room_amenities  as $room_amenitie)
                    @if($room->id == $room_amenitie->room_id)
                      <li class="inline">{{$room_amenitie->amenitie}}</li>
                    @endif
                    @endforeach
                    </ul>
                    <div class="float-right">
                      <ul class="bold text-black">
                        <li class="inline">￥{{$room->h_price}}/h</li>
                        <li class="inline">￥{{$room->day_price}}/泊</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
          {{$room_list->links()}}
        </div>
      </div>
    </section><!-- End Rooms Section -->

  </main><!-- End #main -->
@endsection