<div class="box">
    <div class="box-body box-profile">
    	@if(backpack_auth()->user()->image!='')
    		<img class="profile-user-img img-responsive img-circle" src="{{ env('APP_URL') }}{{backpack_auth()->user()->image }}">
	    @else
	    	<img class="profile-user-img img-responsive img-circle" src="{{URL::asset('/image/default-profile.png')}}">	  

	    @endif

	    
	    <h3 class="profile-username text-center">{{ backpack_auth()->user()->name }}</h3>
	</div>

	<hr class="m-t-0 m-b-0">

	<ul class="nav nav-pills nav-stacked">

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.info')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.update_account_info') }}</a></li>

	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.password')
	  	class="active"
	  	@endif
	  	><a href="{{ route('backpack.account.password') }}">{{ trans('backpack::base.change_password') }}</a></li>


	  <!--
	  <li role="presentation"
		@if (Request::route()->getName() == 'backpack.account.image')
	  	class="active"
	  	@endif
	  	><a href="change-image">Change Image</a></li>
!-->
	</ul>
</div>
