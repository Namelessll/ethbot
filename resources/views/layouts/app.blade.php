<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BitcoinBot v2.0</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
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
    <link rel="stylesheet" href="{{asset('css/app.css')}}">


</head>
<body style="min-height: 100vh; background: #F3F8FB;">
<div id="preloader">
    <div class="loader"></div>
</div>
<div class="page-container">
    <div class="sidebar-menu">
        <div class="sidebar-header">
            <div class="logo" style="text-align: left;">
                <a href="/" style="color: #fff; text-transform: uppercase; font-size: 19px; max-width: 100%;">BITCOIN_BOT 2.0</a>
            </div>
        </div>
        @include('include.menu')
    </div>

    <div class="main-content">
        <div class="header-area">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left" style="margin-top: 0;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 clearfix">
                    <ul class="notification-area pull-right">
                        <li class="dropdown">
                            <i class="fa fa-envelope-o dropdown-toggle" data-toggle="dropdown"><span>3</span></i>
                        </li>
                        <li class="settings-btn">
                            <i class="ti-settings"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-content-inner">
            @yield('content')
        </div>
    </div>
</div>

<div class="offset-area">
    <div class="offset-close"><i class="ti-close"></i></div>
    <ul class="nav offset-menu-tab">
        <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
        <li><a data-toggle="tab" href="#settings">Settings</a></li>
    </ul>
    <div class="offset-content tab-content">
        <div id="activity" class="tab-pane fade in show active">
            <div class="recent-activity">
                @foreach($user_activity as $activity)
                    <div class="timeline-task">
                        <div class="icon @if($activity->activity_code == 'webhook') bg2 @else bg1 @endif">
                            @if($activity->activity_code == 'server')
                                <i class="fa fa-cogs"></i>
                            @elseif($activity->activity_code == 'webhook')
                                <i class="fa fa-connectdevelop"></i>
                            @else
                                <i class="fa fa-send-o"></i>
                            @endif
                        </div>
                        <div class="tm-title">
                            <h4><b>{{$activity->activity_name}}</b></h4>
                            <span class="time"><i class="ti-time"></i>{{$activity->created_at}}</span>
                        </div>
                        <p>{{$activity->activity_description}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="settings" class="tab-pane fade">
            <div class="offset-settings">
                <h4>General Settings</h4>
                <div class="settings-list">
                    <div class="s-settings">
                        <div class="s-sw-title">
                            <h5>Activity</h5>
                            <div class="s-swtich">
                                <form action="{{route('saveActivitySetting')}}" method="POST" id="activity_form" enctype="multipart/form-data">
                                    @csrf

                                    <input onclick="$('#activity_form').submit();" type="checkbox" id="switch1" @if($status_activity[0]->setting_value == 'on') checked @endif name="status" />
                                    <label for="switch1">Toggle</label>
                                </form>

                            </div>
                        </div>
                        <p>Keep track of administrator activity.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('lib/assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script src="{{asset('lib/assets/js/popper.min.js')}}"></script>
<script src="{{asset('lib/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('lib/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('lib/assets/js/metisMenu.min.js')}}"></script>
<script src="{{asset('lib/assets/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('lib/assets/js/jquery.slicknav.min.js')}}"></script>

<!-- start chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- start highcharts js -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<!-- start zingchart js -->
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
</script>
<!-- all line chart activation -->
<script src="{{asset('lib/assets/js/line-chart.js')}}"></script>
<!-- all pie chart -->
<script src="{{asset('lib/assets/js/pie-chart.js')}}"></script>
<!-- others plugins -->
<script src="{{asset('lib/assets/js/plugins.js')}}"></script>
<script src="{{asset('lib/assets/js/scripts.js')}}"></script>
@stack('ajax-mail')
</body>
</html>
