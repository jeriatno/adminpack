@extends('errors.layout')

@php
	$error_number = 500;
@endphp

@section('title')
{{--	It's not you, it's me.--}}
@endsection

@section('description')
	@php
        if(config('app.debug')) {
	        if(isset($exception) && $exception->getMessage()) {
	            $error_message = $exception->getMessage();
            }
        } else {
	        $error_message = "An internal server error has occurred. <br> If the error persists please contact the development team.";
        }
	@endphp
    {!! $error_message !!}
@endsection
