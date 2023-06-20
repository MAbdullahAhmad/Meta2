@extends('layouts.welcome')

@section('content')
  <div class="bg-black columns align-stretch" style="min-height: 100vh;">
    <div class="bg-secondary p20">
      <h2 class="white text-center m0">
        Meta2
      </h2>
    </div>
    <div class="fg-1 columns center align-center">
      <h1 class="title">Welcome to Meta2</h1>
      <div>
        <a href="{{ route('login') }}" class="link btn btn-secondary">Login</a>
        <span class="white">|</span>
        <a href="{{ route('register') }}" class="link btn btn-secondary">Register</a>
      </div>
    </div>
  </div>
@endsection