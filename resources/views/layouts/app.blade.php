<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compitable" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', "交大外卖") - eeYes</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body>
  <div id="app">
    @include('layouts._header')
    <div class="container">
      @include('shared._messages')
      @yield('content')
    </div>
    @include('layouts._footer')
  </div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></scripts>
  @yield('scripts')
</body>
</html>
