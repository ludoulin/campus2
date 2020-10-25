<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Campus') - 校園二手書交易平台</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('sass')

  <link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet">
 
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;400&display=swap" rel="stylesheet">
</head>

<body>
  
  @yield('view')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  @yield('script')

  <script src="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.js"></script>

  <script src="https://kit.fontawesome.com/2db53fc9a8.js" crossorigin="anonymous"></script>
  
</body>

</html>