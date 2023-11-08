<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- toastr -->
  <link rel='stylesheet' href="{{ asset('assets/plugins/ajaxform/toaster.css') }}" type='text/css' media='screen' />
  <!-- validationEngine.jquery -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ve/css/validationEngine.jquery.css') }}" type="text/css"/>
  <style>
    #cover-spin {
        position:fixed;
        width:100%;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display:block;
    }

    @-webkit-keyframes spin {
        from {-webkit-transform:rotate(0deg);}
        to {-webkit-transform:rotate(360deg);}
    }

    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }
    body{
        background-color: rgba(246, 246, 246, 0.6);
    }
    .p-0 {
        padding: 0 !important;
    }
    #cover-spin::after {
        content: '';
        display: block;
        position: absolute;
        left: 48%;
        top: 40%;
        width: 60px;
        height: 60px;
        border-style: dashed;
        border-color: rgb(0,0,0);
        border-top-color: transparent;
        border-width: 5px;
        border-radius: 50%;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }
    .btn-primary {
        background-color: #f1682a !important;
        border-color: #f1682a !important;   
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
        background-color: #f1682a !important;
        border-color: #f1682a !important;
    }
    .authentication-box {
        min-width: 100vw;
        min-height: 100vh;
        width: auto;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .authentication-box .container {
        max-width: 900px;
    }
    .authentication-box .container .bg-primary {
        padding: 50px;
        background-image: url('{{ asset('assets/login-bg.png') }}');
        background-position: center;
        box-shadow: 1px 5px 24px 0 rgb(4 0 255 / 80%);
    }
    .bg-primary {
        background-color: #040493 !important;
        color: #ffffff;
    }
    .authentication-box .container .svg-icon {
        padding: 12px;
        margin: 0 auto;
        border-radius: 10%;
        width: 250px;
        margin-bottom: 20px;

    }
    .authentication-box .container .svg-icon img {
        width: 100%;
    }
    img {
        vertical-align: middle;
        border-style: none;
    }
    .authentication-box .slick-slider {
        margin-bottom: 30px;
    }

    .card-left {
        z-index: 1;
    }

    .authentication-box .container h3 {
        color: #ffffff;
        font-weight: 600;
        text-align: center;
        font-size: 24px;
        letter-spacing: 0.03em;
    }
    .authentication-box .container p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 15px;
        line-height: 2;
        text-align: center;
    }
    .authentication-box .row {
        align-items: center;
    }
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-bottom: 30px;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        border-radius: 8px;
        box-shadow: 1px 5px 24px 0 rgb(68 102 242 / 5%);
    }
    .card .card-body {
        padding: 30px;
        background-color: transparent;
        flex: 1 1 auto;
    }
    .tab-coupon {
        margin-bottom: 30px;
    }
    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }
    .nav {
        display: flex;
        flex-wrap: wrap;
        padding-left: 0;
        list-style: none;
    }
    .authentication-box .tab2-card .nav-tabs .nav-link {
        font-size: 18px;
        transition: 0.3s;
        cursor: pointer;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        display: block;
        padding: 0.5rem 1rem;
    }
    .react-tabs .nav-tabs .nav-link.react-tab-selected, .react-tabs .nav-tabs .nav-link:hover, .react-tabs .nav-tabs .nav-link:focus {
        border-color: transparent transparent transparent !important;
        border-bottom: 2px solid #f1682a !important;
        color: #f1682a;
    }
    .authentication-box .tab2-card .nav-tabs .nav-link svg {
        width: 20px;
        vertical-align: sub;
        margin-right: 5px;
    }
    .authentication-box .container .form-group {
        margin-bottom: 1.5rem;
    }

    .auth-form .form-control {
        border-radius: 25px;
        padding: 9px 25px;
        border: 1px solid #eaeaea;
    }
    .btn:not(:disabled):not(.disabled) {
        cursor: pointer;
    }
    .authentication-box .btn-primary {
        border-radius: 25px;
        margin-top: 12px;
        font-weight: 400;
        padding: 11px 45px;
    }
    .authentication-box .container p.fpsw {
        text-align: left;
        font-size: 16px;    
    } 
    p.fpsw a {color: #AE1000 !important;font-style: italic;}
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Boat Basin Lighting</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password?</p>

      <form action="recover-password.html" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Send</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="login.html">Login</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<div id="cover-spin"></div>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<!-- jquery.validationEngine-en.js -->
<script src="{{ asset('assets/plugins/jquery-ve/js/languages/jquery.validationEngine-en.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('assets/plugins/jquery-ve/js/jquery.validationEngine.js') }}" type="text/javascript" charset="utf-8"></script>
<!-- ajaxform js -->
<script src="{{ asset('assets/plugins/ajaxform/toaster.js') }}"></script>

<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{asset('assets/plugins/jquery/auth-firebase.js')}}"></script>

<script src="{{ asset('assets/plugins/ajaxform/browser.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxform.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxcustom.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#cover-spin").hide();
        
        $(".validation-engine").validationEngine();
        $("#forgot-tab").on('click',function(e){
            $(this).addClass('react-tab-selected');
            $("#login-tab").removeClass('react-tab-selected');
            $(".forgot-tab").show();
            $(".login-tab").hide();
        });
        $("#login-tab").on('click',function(e){
            $(this).addClass('react-tab-selected');
            $("#forgot-tab").removeClass('react-tab-selected');
            $(".forgot-tab").hide();
            $(".login-tab").show();
            
        });
       
    });
</script>
</body>
</html>
