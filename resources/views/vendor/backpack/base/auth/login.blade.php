@extends('backpack::layout_guest')

@section('content')
<style type="text/css">
    @media(max-width: 500px){
        .hide-logo{
            display: none;
        }
    }

    .hide-logo{
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .content-wrapper{
        background: linear-gradient(118deg,  #495464,#495464)!important;
    }

    .main-footer{
        padding: 0px!important;
    }

    .row{
        margin: 0px;
    }

    .content{
        padding: 0px!important;
    }
</style>
<div class="row" style="display: flex;
align-items: center;
height: calc(var(--vh, 1vh) * 100);
justify-content: center;">
<div class="col-md-3">
    <div class="box">
        <div class="box-body" style="padding: 0px">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="col-lg-12 p-t-0">
                    <div class="card rounded-0 mb-0">
                        <div class="card-header pb-1">
                            <div class="card-title p-t-10">
                                <center>
                                    <h3>AdminPack</h3>
                                </center>
                            </div>
                        </div>
                        <div class="card-content p-t-10">
                            <div class="card-body">
                                <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                                    {!! csrf_field() !!}
                                    <div class="form-group{{ $errors->has($username) ? ' has-error' : '' }} has-feedback">
                                        <input type="text" class="form-control" name="{{ $username }}" value="{{ old($username) }}" placeholder="Email">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has($username))
                                        <span class="help-block">
                                            <strong>{{ $errors->first($username) }}</strong>
                                        </span>
                                        @endif

                                    </div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6" style="padding-left: 0px; padding-right: 0px">
                                            <input type="checkbox" name="remember"/> {{ trans('backpack::base.remember_me') }}
                                        </div>
                                        <div class="col-xs-6" style="padding-left: 0px; padding-right: 0px">
                                            @if (backpack_users_have_email())
                                            <div class="text-right"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-xs-12 p-t-20" style="padding-left: 0px; padding-right: 0px">
                                            <button type="submit" class="btn btn-block btn-dark">
                                                {{ trans('backpack::base.login') }}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (config('backpack.base.registration_open'))
    <div class="text-center m-t-10"><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
    @endif
</div>
</div>
@endsection
