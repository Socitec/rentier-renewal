@extends('admin_calender_reserve')

@section('admin_mode')
<label for="start" class="mt-5">利用開始時間</label>
@error('start_time')
<h5 class="error_text">{{$message}}</h5>
@enderror
<input type="text" name="start_time" class="form-control @error('start_time') is-invalid @enderror">
<label for="end" class="mt-5">利用終了時間</label>
@error('end_time')
<h5 class="error_text">{{$message}}</h5>
@enderror
<input type="text" name="end_time" class="form-control @error('end_time') is-invalid @enderror">
<label for="people" class="mt-5">利用人数</label>
@error('stay_people')
<h5 class="error_text">{{$message}}</h5>
@enderror
<input type="number" name="stay_people" class="form-control @error('stay_people') is-invalid @enderror">
<input type="hidden" name="status" value="time">
@endsection