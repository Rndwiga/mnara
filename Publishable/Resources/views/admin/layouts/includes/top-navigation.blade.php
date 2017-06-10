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
                            <a href="{{ route('mnara.logout') }}"
                               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out pull-right"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('mnara.logout') }}" method="POST" style="display: none;">
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