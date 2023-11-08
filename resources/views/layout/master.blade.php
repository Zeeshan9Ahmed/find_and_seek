<?php


//  dd(Auth::user());?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="token" content="{{ csrf_token() }}">

  <title>Boat Basin Lightening</title>
  <link rel="icon" href="{{ url('assets/logo.png') }}" type="image/png" sizes="16x16">
  <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
  <!-- toastr -->
  <link rel='stylesheet' href="{{ asset('assets/plugins/ajaxform/toaster.css') }}" type='text/css' media='screen' />
  <!-- validationEngine.jquery -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ve/css/validationEngine.jquery.css') }}" type="text/css"/>

  @yield('additional_styles')

   <!-- Theme style -->
   <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <!-- My Custom Style -->
  <link rel="stylesheet" href="{{ asset('assets/css/mycustom.css') }}">

</head>
<body class="layout-fixed layout-navbar-fixed layout-footer-fixed ">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('admin/settings') }}" class="nav-link" title="My Account"><i class="fas fa-user"></i> {{ ucfirst(Auth::user()->first_name)  }}  {{  ucfirst(Auth::user()->last_name) }}</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            
            <a href="{{ url('admin/settings') }}" class="nav-link" title="My Account"><i class="fas fa-cog"></i> </a>
            
        </li>
        {{-- @include('layout.li-notification') --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('admin/logout') }}" class="nav-link"><i class="fas fa-sign-out-alt fa-2x text-primary" title="Logout"></i></a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo url('admin/dashboard'); ?>" class="brand-link" style="position:relative !important;">
      <img src="{{ url('public/assets/logo-top.png') }}" alt="Boat Basin Lightening" class="custom-brand-image">
    </a>

    <!-- Sidebar -->
    <div class="sidebar custom-sidebar" >
      <!-- Sidebar user panel (optional) -->
      <nav class="">
        
            @include('layout.admin-nav')
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="{{ url('/') }}">{{ config('app.name', 'Boat Basin Lightening') }}</a>.</strong>
    All rights reserved.
    
  </footer>
</div>
<div id="cover-spin"></div>
<!-- ./wrapper -->
@include('layout.footer-scripts')
@yield('additional_scripts')

</body>
</html>
