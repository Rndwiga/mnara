<!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>{{config('app.name')}}</title>

	<!-- Bootstrap core CSS -->

	<link href="{{ asset('vendor/mnara/css/bootstrap.min.css') }}" rel="stylesheet">
	{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}

	{{--<link href="{{ Theme::asset('mnara::fonts/css/font-awesome.min.css') }}" rel="stylesheet">--}}
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{ asset('vendor/mnara/css/animate.min.css') }}" rel="stylesheet">
	{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">--}}

	<!-- Custom styling plus plugins -->
	<link href="{{ asset('vendor/mnara/css/custom.css') }}" rel="stylesheet">
	{{--<link href="{{ Theme::asset('mnara::css/icheck/flat/green.css') }}" rel="stylesheet">--}}
	<link href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/flat/green.css" rel="stylesheet">
    <!-- Sweetalert (modal) styles  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

	<script src="{{ asset('vendor/mnara/js/jquery.min.js') }}"></script>
	{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>--}}
	<script src="{{ asset('vendor/mnara/js/nprogress.js') }}"></script>
	{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>--}}

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    @yield('header_assets')
</head>


<body class="nav-md">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container body">

	<div class="main_container">

		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">

				<div class="navbar nav_title" style="border: 0; height: 1px; overflow: hidden;">
					<a href="{{ route( config('mnara.route.as').'index') }}" class="site_title"><i class="fa fa-paw"></i> <span>{{Auth::user()->name}}</span></a>
					<br>
				</div>
				<div class="clearfix"></div>

				<!-- menu prile quick info -->
				<div class="profile">
					<div class="profile_pic">
						<img src="https://secure.gravatar.com/avatar/{{Auth::user()->email}}" alt="{{Auth::user()->name}}" class="img-circle profile_img">
					</div>
					<div class="profile_info">
						<span>Welcome,</span>
						<h2>{{Auth::user()->name}}</h2>
					</div>
					<br>
				</div>
				<!-- /menu prile quick info -->
				<!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

					<div class="menu_section">
						<h3>&nbsp;</h3>
						<ul class="nav side-menu">
							<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu" style="display: none">
                                    <li><a href="{{ route( config('mnara.route.as') . 'index') }}"><i class="fa fa-fw fa-tasks pull-left"></i> Dashboard</a></li>
								</ul>
							</li>
							<li><a><i class="fa fa-user"></i> My Account <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu" style="display: none">
                                    <li><a href="#"><i class="fa fa-ellipsis-h fa-xs"></i> Your Roles</a></li>

                                    @forelse(Auth::user()->roles as $role)
                                        <li><a href="{{ route( config('mnara.route.as') . 'role.permission.edit', $role->id) }}"><i class="fa fa-users fa-xs pull-left"></i>  {{ $role->name }}</a></li>
                                    @empty
                                        <li><a href="#"><i class="fa fa-hand-stop-o fa-xs"></i> No roles</a></li>
                                    @endforelse
                                    <li role="separator" class="divider"></li>

								</ul>
							</li>
						</ul>
					</div>

					@if(Auth::check())
					<div class="menu_section">
						<h3>Blog</h3>
							<ul class="nav side-menu">
								<!-- navigation links -->
								{!! GenerateMenu::generateMenu(config('aggregator.navigation')) !!}
							</ul>
						<h3>Administration</h3>
						<ul class="nav side-menu">
							<!-- navigation links -->
							{!! GenerateMenu::generateMenu(config('mnara_menu.navigation')) !!}
						</ul>

					</div>
					@endif

				</div>
				<!-- /sidebar menu -->
				<!-- /menu footer buttons -->
				<div class="sidebar-footer hidden-small">
					<a data-toggle="tooltip" data-placement="top" title="Settings" href="{{ url('/') }}settings">
						<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="FullScreen" onclick="fullscreen()" href="javascript:void(0);">
						<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Authenticator" href="{{ url('/') }}authenticator?csrf={{ csrf_token() }}">
						<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/') }}logout">
						<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					</a>
				</div>
				<!-- /menu footer buttons -->
			</div>
		</div>
		<!-- top navigation -->
		<div class="top_nav">

			<div class="nav_menu">
				<nav class="" role="navigation">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<ul class="nav navbar-nav navbar-right">
						<li class="">
							<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<img src="https://secure.gravatar.com/avatar/{{Auth::user()->name}}" alt="{{Auth::user()->name}}">{{Auth::user()->name}}
								<span class=" fa fa-angle-down"></span>
							</a>
							<ul class="dropdown-menu dropdown-usermenu pull-right">
								{{--<li><a href="{{ url('/') }}authenticator?csrf={{ csrf_token() }}">Authenticator</a></li>
								<li><a href="{{ url('/') }}notifications">Notifications</a></li>
								<li><a href="{{ url('/') }}settings?csrf={{ csrf_token() }}">Settings</a></li>--}}
								<li><a href="{{ route( config('mnara.route.as') . 'index') }}"><i class="fa fa-fw fa-tasks pull-left"></i> Dashboard</a></li>
								<li role="separator" class="divider"></li>
								<li class="text-muted text-center"><i class="fa fa-users"></i> Your Roles</li>
								@forelse(Auth::user()->roles as $role)
									<li><a href="{{ route( config('mnara.route.as') . 'role.permission.edit', $role->id) }}"><i class="fa fa-users fa-xs pull-left"></i>  {{ $role->name }}</a></li>
								@empty
									<li><a href="#"><i class="fa fa-hand-stop-o fa-xs"></i> No roles</a></li>
								@endforelse
								<li role="separator" class="divider"></li>
								<li>
									<a href="{{ url(config('mnara.auth_routes.logout')) }}"
									   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
										<i class="fa fa-fw fa-sign-out pull-left"></i> Logout
									</a>
									<form id="logout-form" action="{{ url(config('mnara.auth_routes.logout')) }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>

		</div>
		<!-- /top navigation -->

		<!-- page content -->
		<div class="right_col" role="main">
		</div>
			@include(config('mnara.views.layouts.flash'))
			@yield('content')
			<!-- footer content -->
			<footer>
				<div class="pull-right">
					{{ date('Y') }} {{config('app.name')}} <a href="https://colorlib.com">{{config('mnara.site_title')}}</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
		<!-- /page content -->
	</div>

</div>
{{----}}
<div id="custom_notifications" class="custom-notifications dsp_none">
	<ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
	</ul>
	<div class="clearfix"></div>
	<div id="notif-group" class="tabbed_notifications"></div>
</div>
<script src="{{ asset('vendor/mnara/js/bootstrap.min.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
<!-- bootstrap progress js -->
{{--<script src="{{ Theme::asset('mnara::js/progressbar/bootstrap-progressbar.min.js') }}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-progressbar/0.9.0/bootstrap-progressbar.min.js"></script>
<!-- icheck -->
{{--<script src="{{ Theme::asset('mnara::js/icheck/icheck.min.js') }}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

<script src="{{ asset('vendor/mnara/js/custom.js') }}"></script>

{{--
<!-- daterangepicker -->
<script type="text/javascript" src="{{ Theme::asset('mnara::js/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/datepicker/daterangepicker.js') }}"></script>
<!-- gauge js -->
<script type="text/javascript" src="{{ Theme::asset('mnara::js/gauge/gauge.min.js') }}"></script>
<!-- chart js -->
<script src="{{ Theme::asset('mnara::js/chartjs/chart.min.js') }}"></script>
<!-- flot js -->
<!--[if lte IE 8]><script type="text/javascript" src="{{ Theme::asset('mnara::js/excanvas.min.js') }}"></script><![endif]-->
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.pie.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.orderBars.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.time.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/date.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.spline.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.stack.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/curvedLines.js') }}"></script>
<!--  <script type="text/javascript" src="{{ Theme::asset('mnara::js/flot/jquery.flot.resize.js') }}"></script>//-->

<!-- worldmap -->
<script type="text/javascript" src="{{ Theme::asset('mnara::js/maps/jquery-jvectormap-2.0.3.min.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/maps/gdp-data.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
<script type="text/javascript" src="{{ Theme::asset('mnara::js/maps/jquery-jvectormap-us-aea-en.js') }}"></script>
<!-- pace -->
<script src="{{ Theme::asset('mnara::js/pace/pace.min.js') }}"></script>
<!-- skycons -->
<script src="{{ Theme::asset('mnara::js/skycons/skycons.min.js') }}"></script>

--}}
<!-- PNotify -->
{{--<script type="text/javascript" src="{{ Theme::asset('mnara::js/notify/pnotify.core.js') }}"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.js"></script>
{{--<script type="text/javascript" src="{{ Theme::asset('mnara::js/notify/pnotify.buttons.js') }}"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.buttons.js"></script>
{{--<script type="text/javascript" src="{{ Theme::asset('mnara::js/notify/pnotify.nonblock.js') }}"></script>--}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.nonblock.min.js"></script>
<!-- Sweetalerts --> <!-- For Delete Modal prompts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
    /**
     * To auto-hide all alerts, except danger
     */
    $('div.alert').not('div.alert-danger').delay(4000).slideUp();

    /**
     * To use the bootstrap tooltip popups.
     */
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body',
        trigger:'click hover focus'
    });

	/*!
	 * For Delete Modal prompts
	 *
	 */
    $('button[type="submit"]').click(function(e) {
        if ( $(this).hasClass('btn-danger') ) {
            var currentForm = this.closest("form");
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this object.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, keep it.",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        currentForm.submit();
                    } else {
                        swal({
                            title: "Cancelled!",
                            text: 'Object not deleted. <br /> <em><small>(I will close in 2 seconds)</em></small>',
                            timer: 2000,
                            showConfirmButton: true,
                            confirmButtonText: "Close now.",
                            type: 'error',
                            html: true
                        });
                    }
                }
            );
        }
    });
</script>
<!-- /datepicker -->
<!-- /footer content -->
@yield('footer_assets')
</body>

</html>