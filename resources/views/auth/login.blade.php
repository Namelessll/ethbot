<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - srtdash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{asset('lib/assets/images/icon/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/metisMenu.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/slicknav.min.css')}}">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{asset('lib/assets/css/typography.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/default-css.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('lib/assets/css/responsive.css')}}">
    <!-- modernizr css -->
    <script src="{{asset('lib/assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>
<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<!-- preloader area start -->
<div id="preloader">
    <div class="loader"></div>
</div>
<!-- preloader area end -->
<!-- login area start -->
<div class="login-area login-s2">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form-head">
                    <h4>Sign In</h4>
                    <p>Hello there, Sign in and start managing your bot dashboard</p>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                        <i class="ti-email"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="form-gp">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <i class="ti-lock"></i>
                        <div class="text-danger"></div>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">{{ __('Login') }} <i class="ti-arrow-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- login area end -->

<!-- jquery latest version -->
<script src="{{asset('lib/assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
<!-- bootstrap 4 js -->
<script src="{{asset('lib/assets/js/popper.min.js')}}"></script>
<script src="{{asset('lib/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('lib/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('lib/assets/js/metisMenu.min.js')}}"></script>
<script src="{{asset('lib/assets/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('lib/assets/js/jquery.slicknav.min.js')}}"></script>

<!-- others plugins -->
<script src="{{asset('lib/assets/js/plugins.js')}}"></script>
<script src="{{asset('lib/assets/js/scripts.js')}}"></script>
</body>

</html>
