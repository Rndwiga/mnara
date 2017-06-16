<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="#" class="site_title"><i class="fa fa-random"></i> <span>{{ config('app.name') }}</span></a>
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
                    @if(config('biashara.navigation'))
                        {{--menu for the tyondo blog package -Aggregator ---}}
                        <h3>Orders</h3>
                        <ul class="nav side-menu">
                            {!! GenerateMenu::generateMenu(config('biashara.navigation')) !!}
                        </ul>
                    @endif
                    <li><a><i class="fa fa-user"></i> My Account <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none">
                            <li><a href="{{ route( config('mnara.route.as') . 'user.profile', Auth::user()->id) }}"><i class="fa fa-ellipsis-h fa-xs"></i> Profile</a></li>
                            @if(Auth::user()->isRole('root'))
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
            {{--@if((new \Illuminate\Routing\RouteCollection())->hasNamedRoute('admin.posts.index'))--}}
            @if(config('mnara.use_aggregator'))
                @if(Auth::check())
                    <div class="menu_section">
                        @if(config('aggregator.navigation'))
                            {{--menu for the tyondo blog package -Aggregator ---}}
                            <h3>Blog</h3>
                            <ul class="nav side-menu">
                                {!! GenerateMenu::generateMenu(config('aggregator.navigation')) !!}
                            </ul>
                        @endif
                    </div>
                @endif
            @endif
            @if(config('mnara.use_company'))
                @if(Auth::check())
                    <div class="menu_section">
                        @if(config('musoni-website-v5.navigation'))
                            {{--menu for the tyondo blog package -Aggregator ---}}
                            <h3>Company</h3>
                            <ul class="nav side-menu">
                                {!! GenerateMenu::generateMenu(config('musoni-website-v5.navigation')) !!}
                            </ul>
                        @endif

                    </div>
                @endif
            @endif
                @if(Auth::user()->isRole('root'))
                    <h3>Administration</h3>
                    <ul class="nav side-menu">
                        <li><a href="{{ route( config('mnara.route.as') . 'dashboard') }}"><i class="fa fa-fw fa-tasks pull-left"></i> Dashboard</a></li>
                        <!-- navigation links -->
                        {!! GenerateMenu::generateMenu(config('mnara_menu.navigation')) !!}
                    </ul>
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
                <form id="logout-form" action="{{ route('mnara.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>