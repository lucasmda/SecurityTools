<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="T-Systems Brazil - AppSec">
  <meta name="author" content="T-Systems Brazil">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- T-Systems Icon -->
  <link rel="icon" href="{{ asset('imagens/MagentaSecurity_2_1.png')}}" type="image/ico" >

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Title Section -->
  <title>@yield('pageTitle') | {{ env('APP_NAME') }}</title>

  <!-- CSS Include -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-4.0.0-beta/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-4.0.0-beta/css/bootstrap-footer.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/Animate.css/animate.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/default.css') }}">
  @if(isset($datatables) && $datatables == true)
  <link rel="stylesheet" href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.min.css') }}" >
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.dataTables.min.css') }}" >
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.dataTables.min.css') }}" >
  @endif
  <!-- Custom CSS -->
  @yield('customCSS')

  <!-- Check Token Script -->
  <script>
  window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
  ]); ?>
  </script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
