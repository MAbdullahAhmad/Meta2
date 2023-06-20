@extends('layouts.welcome')

@section("css")
  <link rel="stylesheet" href="{{ asset('css/gadgets/modal.css') }}">
  <link rel="stylesheet" href="{{ asset('css/panel/main.css') }}">
@endsection

@section("hjs")
  <script src="{{ asset('js/lib/jq.min.js') }} "></script>
  <script src="{{ asset('js/panel.js') }} "></script>
@endsection

@section("js")
<script>
  window.token = '{{ csrf_token() }}';
  window.p = false;
</script>
  <script src="{{ asset('js/panel-setup.js') }}"></script>
@endsection

@section('content')
  <div class="bg-black columns align-stretch" style="height: 100vh;">
    <div class="bg-secondary p20">
      <div class="rows">
        <div>
          <a href="{{ route('info') }}" class="td-none bg-white p5 p15-x para m0 bold cursor-pointer">info</a>
          <a href="{{ route('profile.edit') }}" class="m20-l td-none bg-white p5 p15-x para m0 bold cursor-pointer">Profile</a>
        </div>
        <h2 class="white m0 fg-1 center align-centercursor-pointer" onclick="location.href='{{ route('panel') }}'">
          Meta2
        </h2>
        <div class="bg-primary p5 p15-x para m0 bold d-none" id="curr"></div>
      </div>
    </div>
    @include("components.panel.wall")
  </div>
  <div id="content-display" style="background: #000;" class="d-nosne"></div>
@endsection