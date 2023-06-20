@extends('layouts.welcome')

@section("css")
  <link rel="stylesheet" href="{{ asset('css/panel/info.css') }}">
@endsection

@section('content')
  <div class="bg-black white" style="min-height: 100vh;">
    <div class="bg-secondary p20">
      <h2 class="white m0 fg-1 center align-center cursor-pointer" onclick="location.href='{{ route('panel') }}'">Meta2</h2>
    </div>
    
    <div class="p50">
      <h1 class="title m0">Video</h1><hr>
      <div class="container m50-y">
        <video src="{{ asset('vid/intro.mp4') }}" controls muted autoplay style="width: 100%; height: auto; border: 2px solid #444;"></video>
      </div>
      <br>
      <h1 class="title m0">Info</h1><hr>
      <p class="lead m20-y">
        Hi Bud!<br>
        <br>
        It's All About <b>Control</b> and <b>Navigation</b>:<br>
        <ul class="para">
          <li><div class="m10-y align-center">Click <img src="{{ asset('img/logo.png') }}" alt="logo" class="mini-img"> to go back to &nbsp;<b>panel</b></div></li>
          <li><div class="m10-y align-center">Click <img src="{{ asset('img/plus.png') }}" alt="+" class="mini-img"> to Add a &nbsp;<b>new node</b></div></li>
          <li><div class="m10-y align-center">When &nbsp;<b>Add Node</b>&nbsp; is open, press <div class="mini-box">Enter</div> as a shortcut to add node (instead of clicking <img src="{{ asset('img/add-btn.png') }}" alt="node" class="mini-img"> button). You can also press <div class="mini-box">Enter</div> with combination of <div class="mini-box">Ctrl</div> or <div class="mini-box">Shift</div> if you do not want to close form (helpful in process of adding many nodes together)</div></li>
          <li><div class="m10-y align-center">Hover over a <img src="{{ asset('img/node.png') }}" alt="node" class="mini-img"> to preview it's &nbsp;<b>children</b></div></li>
          <li><div class="m10-y align-center">Hover over a <img src="{{ asset('img/node.png') }}" alt="node" class="mini-img"> and <div class="mini-box">Click</div> to &nbsp;<b>open children</b>&nbsp; in a new shelve</div></li>
          <li><div class="m10-y align-center">Hover over a <img src="{{ asset('img/node.png') }}" alt="node" class="mini-img"> and press <div class="mini-box">Enter</div> to &nbsp;<b>view / edit</b>&nbsp; it's content</div></li>
          <li><div class="m10-y align-center">Hover over a <img src="{{ asset('img/node.png') }}" alt="node" class="mini-img"> and press <div class="mini-box">Delete</div> to &nbsp;<b>delete node</b>&nbsp; and all of its children</div></li>
          <li><div class="m10-y align-center">Hover over a <img src="{{ asset('img/node.png') }}" alt="node" class="mini-img"> and press <div class="mini-box">G</div> to &nbsp;<b>open node</b>&nbsp; in a new panel</div></li>
          <li><div class="m10-y align-center">Press <div class="mini-box">P</div> to &nbsp;<b>open parent node</b>&nbsp; of currently opened node (if it is not root node)</div></li>
          <li><div class="m10-y align-center">Press <div class="mini-box">CapsLock</div> to &nbsp;<b>toggle pause</b>&nbsp; of the device (pause will stop add / edit / delete operation on all nodes for 31 days)</div></li>
          <li><div class="m10-y align-center">When you Hover over a node, it opens up node number (like: <img src="{{ asset('img/node-number.png') }}" alt="node" class="mini-img">) on top right of screen. You can use this number to quickly visit node &nbsp;<b>meta2.nikkabox.com/panel/{node_number}</b>&nbsp; directly</div></li>
          {{-- <li><div class="m10-y align-center">Click <div class="mini-box">OK</div> to Add a &nbsp;<b>new Node</b></div></li> --}}
        </ul>
      </p>
    </div>

  </div>
@endsection