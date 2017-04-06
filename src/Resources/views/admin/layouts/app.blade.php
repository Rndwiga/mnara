<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{asset('vendor/tyondo/mnara/images/favicons/favicon.ico')}}" />
	<title>{{ config('app.name') }}</title>
	<!-- Bootstrap -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
	<!-- NProgress -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/nprogress/nprogress.css')}}" rel="stylesheet">
	<!-- iCheck -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	<!-- Datatables -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('vendor/tyondo/mnara/vendor/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('vendor/tyondo/mnara/vendor/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('vendor/tyondo/mnara/vendor/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
@yield('css')
<!-- Custom Theme Style -->
	<link href="{{asset('vendor/tyondo/mnara/vendor/custom/css/custom.min.css')}}" rel="stylesheet">
</head>

<body class="nav-md">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container body">
	<div class="main_container">
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="#" class="site_title"><i class="fa fa-bank"></i> <span>{{ config('app.name') }}</span></a>
				</div>
				<div class="clearfix"></div>

				<!-- menu profile quick info -->
				<div class="profile clearfix">
					<div class="profile_pic">
						<img src="{{asset('vendor/tyondo/mnara/images/user.png')}}" alt="..." class="img-circle profile_img">
					</div>
					<div class="profile_info">
						<span>Welcome,</span>
						<h2>{{ Auth::user()->name }}</h2>
					</div>
				</div>
				<!-- /menu profile quick info -->
				<br />
				<!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					<div class="menu_section">
						<h3>&nbsp;</h3>
						<ul class="nav side-menu">
							<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu" style="display: none">

								</ul>
							</li>
							<li><a><i class="fa fa-user"></i> My Account <span class="fa fa-chevron-down"></span></a>
								<ul class="nav child_menu" style="display: none">
									<li><a href="{{ route( config('mnara.route.as') . 'user.profile', Auth::user()->id) }}"><i class="fa fa-ellipsis-h fa-xs"></i> Profile</a></li>
									@if(!Auth::check())
										<li><a href="#"><i class="fa fa-ellipsis-h fa-xs"></i> Your Roles</a></li>

										@forelse(Auth::user()->roles as $role)
											<li><a href="{{ route( config('mnara.route.as') . 'role.permission.edit', $role->id) }}"><i class="fa fa-users fa-xs pull-left"></i>  {{ $role->name }}</a></li>
										@empty
											<li><a href="#"><i class="fa fa-hand-stop-o fa-xs"></i> No roles</a></li>
										@endforelse
										<li role="separator" class="divider"></li>
									@endif
								</ul>
							</li>
						</ul>
					</div>
					@if(Auth::check())
						<div class="menu_section">
							@if(config('aggregator.navigation'))
								{{--menu for the tyondo blog package -Aggregator ---}}
								<h3>Blog</h3>
								<ul class="nav side-menu">
									{!! GenerateMenu::generateMenu(config('aggregator.navigation')) !!}
								</ul>
							@endif
							<h3>Administration</h3>
							<ul class="nav side-menu">
								<li><a href="{{ route( config('mnara.route.as') . 'index') }}"><i class="fa fa-fw fa-tasks pull-left"></i> Dashboard</a></li>
								<!-- navigation links -->
								{!! GenerateMenu::generateMenu(config('mnara_menu.navigation')) !!}
							</ul>

						</div>
					@endif
				</div>
				<!-- /sidebar menu -->
				<!-- /menu footer buttons -->
				<div class="sidebar-footer hidden-small">
					<a data-toggle="tooltip" data-placement="top" title="Settings">
						<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="FullScreen">
						<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Lock">
						<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}"
					   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
						<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</a>
				</div>
				<!-- /menu footer buttons -->
			</div>
		</div>

		<!-- top navigation -->
		<div class="top_nav">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>

					<ul class="nav navbar-nav navbar-right">
						<li class="">
							<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<img src="{{asset('vendor/tyondo/mnara/images/user.png')}}" alt="">{{ Auth::user()->name }}
								<span class=" fa fa-angle-down"></span>
							</a>
							<ul class="dropdown-menu dropdown-usermenu pull-right">
								<li><a href="{{url('/')}}" target="_blank" ><i class="fa fa-globe pull-right"></i> Visit Site</a></li>
								<li><a href="{{url('admin/users', Auth::user()->id)}}"><i class="fa fa-lock pull-right"></i>
										Change Password</a></li>
								<li><a href="{{ route( config('mnara.route.as') . 'user.profile', Auth::user()->id) }}"><i class="fa fa-user pull-right"></i> Profile</a></li>
								{{--<li><a href="javascript:;">Help</a></li>--}}
								<li role="separator" class="divider"></li>
								<li>
									<a href="{{ url('/logout') }}"
									   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
										<i class="fa fa-sign-out pull-right"></i>Logout
									</a>
									<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
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
	@yield('content')
	<!-- /page content -->
		<!-- footer content -->
		<footer>
			<div class="pull-right">
				{{ config('app.name') }} by <a href="{{config('mnara.site_url')}}">{{config('mnara.site_title')}}</a>
			</div>
			<div class="clearfix"></div>
		</footer>
		<!-- /footer content -->
	</div>
</div>

<!-- jQuery -->
<script src="{{asset('vendor/tyondo/mnara/vendor/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('vendor/tyondo/mnara/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('vendor/tyondo/mnara/vendor/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('vendor/tyondo/mnara/vendor/nprogress/nprogress.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('vendor/tyondo/mnara/vendor/iCheck/icheck.min.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/datatables.net-scroller/js/datatables.scroller.min.js')}}"></script>

<script src="{{asset('vendor/tyondo/mnara/vendor/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('vendor/tyondo/mnara/vendor/pdfmake/build/vfs_fonts.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('vendor/tyondo/mnara/vendor/custom/js/custom.min.js')}}"></script>
@yield('script')

<!-- Datatables -->
<script>
    $(document).ready(function() {
        var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
                $("#datatable-buttons").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: "copy",
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            className: "btn-sm"
                        },
                        {
                            extend: "excel",
                            className: "btn-sm"
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm"
                        },
                        {
                            extend: "print",
                            className: "btn-sm"
                        },
                    ],
                    responsive: true
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        $('#datatable').dataTable();


        TableManageButtons.init();
    });
</script>
<!-- /Datatables -->
@include(config('mnara.views.shared.google-analytics'))
</body>
</html>
