@extends(config('mnara.views.layouts.master'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Google 2FA</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="col-md-6">
                                <p>secret key</p>
                            </div>
                            <div class="col-md-6">
                                <b>{{ $key }}</b>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                Google QRCode
                            </div>
                            <div class="col-md-6">
                                <img src="{{ $googleUrl }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <form action="/home" method="post">
                                    Type your code: <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="text" name="code">
                                    <input type="submit" value="check">
                                </form>
                            </div>
                            <div class="col-md-6">
                                @if ($valid)
                                    <div style="color: green; font-weight: 800;">VALID</div>
                                @else
                                    <div style="color: red; font-weight: 800;">INVALID</div>
                                @endif
                            </div>

                        </div>
            </div>
        </div>
    </div>
</div>
@endsection
