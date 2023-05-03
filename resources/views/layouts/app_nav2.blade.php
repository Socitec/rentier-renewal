@extends('layouts.app')

@section('nav')
<!-- navbar -->
<nav id="navbar" class="navbar order-last order-lg-0">
@auth
  <a class="btn btn-primary text-white mr-1" href="{{action('\App\Http\Controllers\Admin_Controller@index')}}">管理者画面へ</a>
  <form action="{{url('/logout')}}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary text-white p-1">ログアウト</button>
  </form>
  @else
  <!-- <a href="{{url('/register')}}" class="btn btn-primary text-white mr-1">管理者用登録ページへ</a> -->
  <!-- <a href="{{url('/login')}}" class="btn btn-primary text-white">管理者用ログインページへ</a> -->
  @endauth
  <ul>
    <li><a class="nav-link scrollto" href="{{url('/')}}">ホーム</a></li>
    <li><a class="nav-link scrollto active" href="{{url('/about')}}">はじめての方へ</a></li>
    <li><a class="nav-link scrollto" href="{{url('/rooms')}}">お部屋一覧</a></li>
    <li><a class="nav-link scrollto" href="{{url('/contact')}}">お問い合わせ</a></li>
  </ul>
  <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- /navbar -->
@endsection