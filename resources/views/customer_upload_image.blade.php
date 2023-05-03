@extends('layouts.app_nav1')

@section('style')
<style>
  .imagePreview {
    width: 100%;
    height: 100px;
    background-position: center center;
    background-size: contain;
    background-repeat: no-repeat;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
  }
</style>
@endsection

@section('content')
<!-- ======= Hero_about Section ======= -->
<section id="hero_contact" class="d-flex align-items-center">
    <div class="container text-center">
      <h1 class="mt-7 pt-5">利用者顔写真アップロード</h1>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 mx-auto">
            <div class="text-center mt-5">
              <h2>利用者氏名の入力、写真を添付して送信ボタンを押してください。</h2>
              @if(isset($err_message))
              <h2 class="text-red">{{$err_message}}</h2>
              @endif
              <form class="d-block mx-auto w-75" method="POST" enctype="multipart/form-data" action="/customercheckin/{{$reserve_num}}/{{$user_num}}/upload_image">
                @csrf
                <h6 class="text-red bold">身分証明書（運転免許証、健康保険証、パスポート等）<br>
                ※外国籍の方はパスポート（または在留カード）のお名前、顔写真のページをご提示ください。</h6>
                <div class="form-group">
                  @for ($i=1; $i<$user_num+1; $i++)
                  <h2 class="control-label">氏名{{$i}}</h2>
                  <input class="form-control" name="name_{{$i}}" type="text">
                  <h2>お部屋での自撮り写真{{$i}}</h2>
                  <div class="imagePreview"></div>
                  <div class="input-group">
                    <label class="input-group-btn">
                      <span class="btn btn-primary">
                        写真を選択<input type="file" name="image_{{$i}}" style="display:none" class="uploadFile">
                      </span>
                    </label>
                    <input type="text" class="form-control" readonly="">
                  </div>
                  <h2>身分証明書の表写真{{$i}}</h2>
                  <div class="imagePreview"></div>
                  <div class="input-group">
                    <label class="input-group-btn">
                      <span class="btn btn-primary">
                        写真を選択<input type="file" name="id_card_front_{{$i}}" style="display:none" class="uploadFile">
                      </span>
                    </label>
                    <input type="text" class="form-control" readonly="">
                  </div>
                  <h2>身分証明書の裏写真{{$i}}</h2>
                  <div class="imagePreview"></div>
                  <div class="input-group">
                    <label class="input-group-btn">
                      <span class="btn btn-primary">
                        写真を選択<input type="file" name="id_card_back_{{$i}}" style="display:none" class="uploadFile">
                      </span>
                    </label>
                    <input type="text" class="form-control" readonly="">
                  </div>
                  @endfor
                </div>
                <button type="submit" class="btn btn-primary mt-3">送信</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection

@section('script')
  <script>
    $(document).on('change', ':file', function() {
      var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.parent().parent().next(':text').val(label);

      var files = !!this.files ? this.files : [];
      if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
      if (/^image/.test( files[0].type)){ // only image file
          var reader = new FileReader(); // instance of the FileReader
          reader.readAsDataURL(files[0]); // read the local file
          reader.onloadend = function(){ // set image data as background of div
          input.parent().parent().parent().prev('.imagePreview').css("background-image", "url("+this.result+")");
        }
      }
    });
  </script>
@endsection