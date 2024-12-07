@extends('backpack::layout')
@section('header')
    <section class="content-header">

        <h1>
            {{ trans('backpack::base.my_account') }}
        </h1>

        <ol class="breadcrumb">

            <li>
                <a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a>
            </li>

            <li>
                <a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.my_account') }}</a>
            </li>

            <li class="active">
                {{ trans('backpack::base.update_account_info') }}
            </li>

        </ol>

    </section>
@endsection

@section('content')
    <div class="row">
        <form class="form" action="{{ route('backpack.account.info') }}" method="post" enctype="multipart/form-data" ">
            <div class="col-md-3">
                @include('auth.account.sidemenu')
            </div>
            <div class="col-md-6">


                {!! csrf_field() !!}

                <div class="box padding-10">

                    <div class="box-body backpack-profile-form">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->count())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            @php
                                $label = trans('backpack::base.name');
                                $field = 'name';
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control" type="text" name="{{ $field }}"
                                   value="{{ old($field) ? old($field) : $user->$field }}">
                        </div>

                        <div class="form-group">
                            @php
                                $label = config('backpack.base.authentication_column_name');
                                $field = backpack_authentication_column();
                            @endphp
                            <label class="required">{{ $label }}</label>
                            <input required class="form-control"
                                   type="{{ backpack_authentication_column()=='email'?'email':'text' }}"
                                   name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                        </div>

                        <div class="form-group">
                            <label class="required">Phone Number</label>
                            <input required="" class="form-control" type="text" name="msisdn"
                                   value="{{ $user->msisdn ?? '' }}">
                        </div>

                        <div class="form-group m-b-0">
                            <button type="submit" class="btn btn-success"><span class="ladda-label"><i
                                        class="fa fa-save"></i> {{ trans('backpack::base.save') }}</span></button>
                            <a href="{{ backpack_url() }}" class="btn btn-default"><span
                                    class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection



