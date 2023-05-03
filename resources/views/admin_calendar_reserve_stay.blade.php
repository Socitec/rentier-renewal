@extends('admin_calender_reserve')

@section('admin_mode')
<!-- <label for="stay">宿泊日数</label>
<input type="number" name="stay_num"> -->
<label for="people" class="mt-5">宿泊人数</label>
@error('stay_people')
<h5 class="error_text">{{$message}}</h5>
@enderror
<input type="number" name="stay_people" class="form-control @error('stay_people') is-invalid @enderror">
<label for="checkin" class="mt-5">チェックイン時間</label>
@error('checkin_time')
<h5 class="error_text">{{$message}}</h5>
@enderror
<input type="text" name="checkin_time" class="form-control @error('checkin_time') is-invalid @enderror">
<input type="hidden" name="status" value="stay">
@endsection