@extends('layouts/app_nav3')

@section('style')
<script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>
<script>
  const appId = "{{ config('square.application_id') }}";
  const locationId = "{{ config('square.location_id') }}";

  async function initializeCard(payments) {
    const card = await payments.card();
    await card.attach('#card-container'); 
    return card; 
  }

  document.addEventListener('DOMContentLoaded', async function () {
    if (!window.Square) {
      throw new Error('Square.js failed to load properly');
    }
    const payments = window.Square.payments(appId, locationId);
    let card;
    try {
      card = await initializeCard(payments);
    } catch (e) {
      console.error('Initializing Card failed', e);
      return;
    }

    // Step 5.2: create card payment

    // Call this function to send a payment token, buyer name, and other details
    // to the project server code so that a payment can be created with 
    // Payments API
    async function createPayment(token) {
      const body = JSON.stringify({
        locationId,
        sourceId: token,
      });
      return body;
    }

    // This function tokenizes a payment method. 
    // The ‘error’ thrown from this async function denotes a failed tokenization,
    // which is due to buyer error (such as an expired card). It is up to the
    // developer to handle the error and provide the buyer the chance to fix
    // their mistakes.
    async function tokenize(paymentMethod) {
      const tokenResult = await paymentMethod.tokenize();
      if (tokenResult.status === 'OK') {
        return tokenResult.token;
      } else {
        let errorMessage = `Tokenization failed-status: ${tokenResult.status}`;
        if (tokenResult.errors) {
          errorMessage += ` and errors: ${JSON.stringify(
            tokenResult.errors
          )}`;
        }
        throw new Error(errorMessage);
      }
    }

    async function handlePaymentMethodSubmission(event, paymentMethod) {
      event.preventDefault();

      try {
        // disable the submit button as we await tokenization and make a
        // payment request.
        cardButton.disabled = true;
        const token = await tokenize(paymentMethod);
        const paymentResults = await createPayment(token);
        document.getElementById("key-value").innerHTML = "<input type='hidden' name='key-value' value='" + paymentResults +"'>";
        document.getElementById("card-container").classList.add('hidden');
        setTimeout(function(){document.getElementById("check_button").innerHTML = "<div class='btn btn-secondary'>入力済み</div>"}, 500);
      } catch (e) {
        cardButton.disabled = false;
        console.error(e.message);
      }
    }

    const cardButton = document.getElementById(
      'card-button'
    );
    cardButton.addEventListener('click', async function (event) {
      await handlePaymentMethodSubmission(event, card);
    });
  });
</script>
@endsection

@section('content')
  <!-- ======= Hero Section ======= -->
  <section id="hero_rooms" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">お部屋予約確認(時間貸し)</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Rooms Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <h1>お部屋予約確認(時間貸し)</h1>
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
            <h3 class="bold mt-5">ご利用人数:</h3>
            <h3 class="bold">{{$get_query1->stay_people}}人</h3>
            <table>
              <tr>
                <th><h3 class="bold">ご利用料金:</h3></th>
                <td><h3 class="bold">{{$pay}}円</h3></td>
              </tr>
            </table>
            <form id="payment-form" action="/roomsreserve_time/confirm/{{$room_id}}/{{$add_data_id}}/{{$get_query1->name}}/{{$get_query1->email}}" enctype="multipart/form-data" method="POST">
              @csrf
              <table class="mt-4">
                <tr>
                  <th><h2>身分証明書(表面)</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('image_front')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input class="form-control full_width mt-2 border_require @error('image_front') is-invalid @enderror" type="file" id="image_front" name="image_front">
              <table class="mt-4">
                <tr>
                  <th><h2>身分証明書(裏面)</h2></th>
                  <th><p class="contact_require">必須</p></th>
                  @error('image_back')
                  <th><h5 class="error_text">{{$message}}</h5></th>  
                  @enderror
                </tr>
              </table>
              <input class="form-control full_width mt-2 border_require @error('image_back') is-invalid @enderror" type="file" id="image_back" name="image_back">
              <div class="mt-2">
                <span class="text-red bold">※身分証明書としては運転免許証、マイナンバーカード等、個人情報と顔写真がわかるものをお願い致します。また、画像はjpg又はpng形式で40MB以下でお願い致します。</span>
              </div>
              <div id="card-container"></div>
              <div id="key-value"></div>
              <table>
                <tr>
                  <th><span>決済用のクレジットカードの情報は入力しましたか？</span></th>
                  <td><div id="check_button"><button type="button" class="btn btn-primary" id="card-button">はい</button></div></td>
                </tr>
              </table>
              <p class="text-red bold">※確認ボタンを押さなければ決済されません。ご注意ください。</p>
              <h5 class="bold">キャンセルについて</h5>
              <p class="bold">
                予約成立から48時間以内のキャンセル受付：キャンセル料無料、サービス料無料（但し、年3回まで）<br>
                予約成立から48時間以降のキャンセル受付：キャンセル料無料、サービス料（ご利用料金の5%）を請求<br>
                ご利用日初日の開始時間の14日前を過ぎてのキャンセル受付：キャンセル料（ご利用料金の50%）とサービス料<br>
                ご予約完了から24時間以内のキャンセル：キャンセル料無料、サービス料無料（ただし、ご利用開始日の14日前を過ぎている場合は(2)及び(3)のキャンセル料が適用となります）
              </p>
              <div class="text-center">
                <a href="/roomsreserve_time/retly/{{$room_id}}/{{$add_data_id}}/{{$get_query1->name}}/{{$get_query1->email}}" class="btn btn-success">予約設定をやり直す</a>
                <button type="submit" class="btn btn-primary">決済して予約を確定する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- End Rooms Section -->

  </main><!-- End #main -->
@endsection