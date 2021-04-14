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

  <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">

  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;400&display=swap" rel="stylesheet">

  
  
  <script>
   window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),])!!};
  </script>

</head>

<body>
  
  @yield('view')

  
  <script src="{{ asset('js/app.js') }}"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script> 

  <script src="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.js"></script>

  <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>


  @yield('script')


  <script src="https://kit.fontawesome.com/2db53fc9a8.js" crossorigin="anonymous"></script>

  <script src="{{ asset('js/AlertMessage.js') }}"></script>

  <script src="{{ asset('js/Validation.js') }}"></script>

</body>

</html>