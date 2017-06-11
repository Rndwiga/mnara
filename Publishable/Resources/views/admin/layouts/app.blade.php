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

@if(\Request::is('mnara') || \Request::is('/') ||\Request::is('mnara/register') || \Request::is('client/login') || \Request::is('client/password/request') || \Request::is('client/password/reset'))
	<body class="login">
		@yield('content')
	</body>
@else
<body class="nav-md">
		<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div class="container body">
			<div class="main_container">
				<!-- /left-bar -->
			@include(config('mnara.views.layouts.includes.left'))
			<!-- /left-bar -->
				<!-- top navigation -->
			@include(config('mnara.views.layouts.includes.top'))
			<!-- /top navigation -->

				<!-- page content -->
			@yield('content')
			<!-- /page content -->
				<!-- footer content -->
			@yield(config('mnara.views.layouts.includes.footer'))
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
@endif
</html>
