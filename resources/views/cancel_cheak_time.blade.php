@extends('layouts/app_nav3')

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero_rooms" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お部屋キャンセル確認(宿泊)</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Rooms Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <h3>以下の内容の部屋をキャンセルさせていただきます。<br>よろしいでしょうか？</h3>
            @if(isset($error_message))
            <h3 class="text-red bold">{{$error_message}}</h3>
            @endif
            <h3>以下の内容で予約をさせていただきます。よろしいでしょうか？</h3>
            <h3 class="bold mt-5">お名前:</h3>
            <h3 class="bold">{{$get_query1->name}}</h3>
            <h3 class="bold mt-5">メールアドレス:</h3>
            <h3 class="bold">{{$get_query1->email}}</h3>
            <h3 class="bold mt-5">電話番号:</h3>
            <h3 class="bold">{{$get_query1->tel}}</h3>
            <h3 class="bold mt-5">予約開始日:</h3>
            <h3 class="bold">{{$get_query1->date}}</h3>
            <h3 class="bold mt-5">利用開始時間:</h3>
            <h3 class="bold">{{$get_query1->start_time}}</h3>
            <h3 class="bold mt-5">利用終了時間:</h3>
            <h3 class="bold">{{$get_query1->end_time}}</h3>
            <table>
              <tr>
                <th><h3 class="bold">ご利用料金:</h3></th>
                <td><h3 class="bold">{{$pay}}円</h3></td>
              </tr>
            </table>
            <div class="text-center">
              <h5 class="bold mt-5">
                <font color="red">キャンセル処理が確定をした際にレンティア運営からメールさせて頂きます。</font>
              </h5>
            </div>
            <form action="/customercancel_done" enctype="multipart/form-data" method="POST">
              @csrf
              <input type="hidden" name="reserve_num_id" value="{{$reserve_num->id}}">
              <div class="text-center">
                <button type="submit" class="btn btn-primary">キャンセルする</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Rooms Section -->

  </main><!-- End #main -->
@endsection