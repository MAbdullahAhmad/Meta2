<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <title>Meta2 | Nikkabox</title>

    <link rel="stylesheet" href="{{ asset('css/global/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/setup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/typo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/spaces.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/geometry.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/misc.css') }}">

    @yield('css')
    @yield('hjs')
  </head>
  <body>
    @yield('content')
    @yield('js')
  </body>
</html>