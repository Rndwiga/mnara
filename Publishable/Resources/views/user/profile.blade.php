@extends(config('mnara.views.layouts.master'))
@section('css')
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User Profile</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User Report <small>Activity report</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <div class="profile_img">
                                    <div id="crop-avatar">
                                        <!-- Current avatar -->
                                        <img class="img-responsive avatar-view" src="{{asset('vendor/tyondo/mnara/images/user.png')}}" alt="Avatar" title="Change the avatar">
                                    </div>
                                </div>
                                <h3>{{ Auth::user()->name }}</h3>

                                <ul class="list-unstyled user_data">
                                    <li><i class="fa fa-envelope user-profile-icon"></i> {{Auth::user()->email}}
                                    </li>
                                    @forelse(Auth::user()->roles as $role)
                                        <li><i class="fa fa-users user-profile-icon"></i> Role:
                                            <a href="{{ route( config('mnara.route.as') . 'role.permission.edit', $role->id) }}">{{ $role->name }}</a>
                                        </li>
                                    @empty
                                        <li><a href="#"><i class="fa fa-hand-stop-o fa-xs"></i> No roles</a></li>
                                    @endforelse
                                </ul>
                                {{--<a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>--}}
                                <br />
                                <!-- start skills -->
                                <!-- end of skills -->

                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">

                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                                        </li>
                                        {{--<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                                        </li>--}}
                                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Profile</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                            <!-- start recent activity -->
                                            <ul class="messages">
                                                @include(config('mnara.views.users.account-activity'))
                                            </ul>
                                            <!-- end recent activity -->

                                        </div>
                                        {{--<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                            <!-- start user projects -->
                                            <table class="data table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Project Name</th>
                                                    <th>Client Company</th>
                                                    <th class="hidden-phone">Hours Spent</th>
                                                    <th>Contribution</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>New Company Takeover Review</td>
                                                    <td>Deveint Inc</td>
                                                    <td class="hidden-phone">18</td>
                                                    <td class="vertical-align-mid">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" data-transitiongoal="35"></div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            <!-- end user projects -->
                                        </div>--}}
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                            <h3> Update your details </h3>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        {{Form::model($resource, ['method' => 'PATCH', 'route' => [ 'mnara.user.update', $resource->id ]])}}
                                                        <div class="input-group form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                            <span class="input-group-addon" id="name">Name</span>
                                                            {{Form::text('name', null, ['class' => 'form-control','placeholder'=>'Username','aria-describedby'=>'name'])}}
                                                            {!! $errors->first('name', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
                                                        </div>
                                                        <div class="input-group form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                            <span class="input-group-addon" id="email">Email Address</span>
                                                            {{Form::text('email', null, ['class' => 'form-control','placeholder'=>'Email Address','aria-describedby'=>'email'])}}
                                                            {!! $errors->first('email', '<div class="col-sm-6 col-sm-offset-3 text-danger">:message</div>') !!}
                                                        </div>
                                                        <div class="input-group form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                                            <span class="input-group-addon" id="password">Password</span>
                                                            <input type="password" class="form-control" name="password" aria-describedby="password">
                                                            {{$errors->first('password', '<div class="text-danger">:message</div>') }}
                                                        </div>
                                                        <div class="input-group form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                                            <span class="input-group-addon" id="password_confirmation">Password Confirmation</span>
                                                            <input type="password" class="form-control" name="password_confirmation" aria-describedby="password_confirmation">
                                                            {{$errors->first('password_confirmation', '<div class="text-danger">:message</div>') }}
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="submit" class="btn btn-primary btn-block" >
                                                        </div>
                                                        {{Form::close()}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <!-- morris.js -->
    <script src="../vendors/raphael/raphael.min.js"></script>
    <script src="../vendors/morris.js/morris.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
@endsection