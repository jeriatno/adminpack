<div class="user-panel">
  <br>
  <a class="pull-left image" href="{{ route('backpack.account.info') }}">
  	@if(backpack_auth()->user()->image!='')
    	<img src="{{backpack_auth()->user()->photo }}" class="img-circle" alt="User Image">
    @else
    	<img src="{{URL::asset('/image/default-profile.png')}}" class="img-circle" alt="User Image">
    @endif
  </a>
  <div class="pull-left info">
    <p><a href="{{ route('backpack.account.info') }}">{{ backpack_auth()->user()->name }}</a></p>
    <small><small><a href="{{ route('backpack.account.info') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ backpack_url('logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
  </div>
</div>
