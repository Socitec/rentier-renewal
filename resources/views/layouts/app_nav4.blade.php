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
  <!-- Property画面用 -->
  <ul class="header__menu-list">
    <li class="header__menu-item"><a class="nav-link scrollto" href="{{url('/about')}}">レンティアとは</a></li>
    <li class="header__menu-item"><a class="nav-link scrollto" href="{{url('/land')}}">土地を探したい</a></li>
    <li class="header__menu-item"><a class="nav-link scrollto active" href="{{url('/property')}}">物件を探したい</a></li>
    <li class="header__menu-item"><a class="nav-link scrollto" href="{{url('/stay')}}">宿泊・レンタルしたい</a></li>
    <li class="header__menu-item header__menu-item--background"><a class="nav-link scrollto" href="{{url('/contact')}}"><img src="{{asset('assets/img/header_icon_mail.svg')}}" alt="mail">お問い合わせ</a></li>
  </ul>
  <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- /navbar -->
@endsection