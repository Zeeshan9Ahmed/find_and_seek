<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }} | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
        border-color: #040493;
        border-top-color: transparent;
        border-width: 5px;
        border-radius: 50%;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
    }
    .btn-primary {
        background-color: #87CEEB !important;
        border-color: #87CEEB !important;   
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
        background-color: #87CEEB !important;
        border-color: #87CEEB !important;
    }
    .authentication-box {
        min-width: 100vw;
        min-height: 100vh;
        width: auto;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
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
        border-bottom: 2px solid #87CEEB !important;
        color: #87CEEB;
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
    .logoBox img {
        max-width: 170px;
    }
    p.fpsw a {color: #AE1000 !important;font-style: italic;}
</style>
</head>
<body class="hold-transition">
    <div class="authentication-box">

    <div class="logoBox pb-5 text-center">
        <img src="{{asset('assets/basinLogo.png')}}" alt="">
    </div> 
        <div class="container">
           <div class="row justify-content-center">
              <div class="col-lg-7 col-md-7 col-sm-12 col-12 p-0 card-right">
                 <div class="card tab2-card">
                    <div class="card-body">
                       <div>
                          <div class="react-tabs" data-tabs="true">
                             <ul class="nav nav-tabs tab-coupon" role="tablist">
                                <li class="nav-link react-tab-selected" role="tab" id="login-tab" aria-selected="true" aria-disabled="false" aria-controls="react-tabs-0" tabindex="0">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                      <circle cx="12" cy="7" r="4"></circle>
                                   </svg>
                                   Login
                                   </li>
                                   {{--
                                    <li class="nav-link react-tab-selected" role="tab" id="forgot-tab" aria-selected="true" aria-disabled="false" aria-controls="react-tabs-0" tabindex="0">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                      <circle cx="12" cy="7" r="4"></circle>
                                   </svg>
                                   Forgot
                                   </li>
                                    --}}
                             </ul>
                             
                             <div class="login-tab" role="tabpanel">
                                <form class="form-horizontal auth-form ajaxForm" action="{{ route('admin.login') }}" method="post">
                                    {{ csrf_field() }}
                                   <div class="form-group"><input type="email" name="email" class="form-control validate[required,custom[email]]" placeholder="Email" id="exampleInputEmail1"></div>
                                   <div class="form-group"><input type="password" name="password" class="form-control validate[required]" placeholder="Password"></div>
                                   <input type="hidden" name="device_token" id="device_token" value=""/>
                                   <div class="form-button"><button class="btn btn-primary login-btn" id="btn" type="submit">Login</button></div>
                                </form>
                             </div>
                             <div class="forgot-tab" role="tabpanel" style="display: none">
                                <form class="form-horizontal auth-form ajaxForm" action="{{ url('forgot-password') }}" method="post">
                                    {{ csrf_field() }}
                                   <div class="form-group"><input type="email" name="email" class="form-control validate[required,custom[email]]" placeholder="Enter Your Registered Email" id="exampleInputEmail2"></div>
                                   <div class="form-button"><button class="btn btn-primary" type="submit">SEND</button></div>
                                </form>
                             </div>
                          </div>
                          <div class="Toastify"></div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>


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

<script src="{{ asset('assets/plugins/ajaxform/browser.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxform.js') }}"></script>
<script src="{{ asset('assets/plugins/ajaxform/ajaxcustom.js') }}"></script>

<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="{{ asset('assets/plugins/jquery/auth-firebase.js') }}"></script>

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
