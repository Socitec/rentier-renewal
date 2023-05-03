@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero_about Section ======= -->
  <section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">管理者用予約画面</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <form method="post" action="{{url('/admin_reserve_create')}}">
                @csrf
	              <div>
	              	<label for="room">部屋を選択してください</label>
		              <select name="room" class="form-control">
		                <option value="1">【52Rレンタルスペース】ワンルーム・博多駅徒歩10分・キャナルシティ、天神も近い好立地のレンタルスペース・充実の設備</option>
		                <option value="2">【55CRレンタルスペース】ワンルーム・博多駅徒歩10分・キャナルシティ、天神も近い好立地のレンタルスペース・充実の設備</option>
		                <option value="3">【56CRレンタルスペース】ワンルーム・博多駅徒歩10分・キャナルシティ、天神も近い好立地のレンタルスペース・充実の設備</option>
		                <option value="4">【57CRレンタルスペース】ワンルーム・博多駅徒歩10分・キャナルシティ、天神も近い好立地のレンタルスペース・充実の設備</option>
                    <option value="5">【71GDデザイナーズレンタルスペース】中村区役所徒歩３分・ワンルーム・充実設備</option>
                    <option value="6">【63Pデザイナーズレンタルスペース】池下駅徒歩１分・駅目の前の1DK・充実設備</option>
                  </select>
	              </div>

                <!-- 日付入力 -->
                <label for="calender" class="mt-5">日付を入力してください。</label>
                @error('date')
                <h5 class="error_text">{{$message}}</h5>
                @enderror
                <input id="date" type="date" name="date" class="form-control @error('date') is-invalid @enderror" min="{{date('Y-m-d')}}">

                <input type="hidden" name="name" value="dummy">
                <input type="hidden" name="email" value="dummy@gmail.com">
                <input type="hidden" name="tel" value="09000000000">

                <!-- 宿泊か時間貸しかで処理を分岐させる -->
                @yield('admin_mode')

                <button type="submit" class="btn btn-primary mt-5">予約をする</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection