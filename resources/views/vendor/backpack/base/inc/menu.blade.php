
<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        @if (backpack_auth()->check())
            <!-- Topbar. Contains the left part -->
            @include('backpack::inc.topbar_left_content')

                <!--<li><a href="#"><b>{{ config('backpack.base.project_name') }}</b></a></li>!-->
<!--                 <li><a href="#"><font size="3em" >{{ config('backpack.base.project_name') }}</font></a></li>
                 -->
                <div class="headline">{{ config('backpack.base.project_name') }}</div>
        @endif
    <!-- ========== End of top menu left items ========== -->
    </ul>
</div>



<div class="navbar-custom-menu pull-right">

    <ul class="nav navbar-nav">
        <!-- ========================================================= -->
        <!-- ========= Top menu right items (ordered right) ========== -->
        <!-- ========================================================= -->

        @if (config('backpack.base.setup_auth_routes'))
            @if (backpack_auth()->guest())
                <li>
                    <a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a>
                </li>
                @if (config('backpack.base.registration_open'))
                    <li><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></li>
                @endif
            @else
                <!-- Topbar. Contains the right part -->
                @include('backpack::inc.topbar_right_content')
                @role('Helpdesk')
                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#modalSwitchAccount"><i class="fa fa-btn fa-users"></i> Switch Account</a></li>
                @endrole
                <li><a href="{{ route('backpack.auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
            @endif
        @endif
        <!-- ========== End of top menu right items ========== -->
    </ul>
</div>

@role('Helpdesk')
@push('after_scripts')
    <div class="modal fade" id="modalSwitchAccount" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Switch Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ backpack_url('switch-account') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>

                        <button class="btn btn-block btn-primary" type="submit">Switch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
@endpush
@endrole

