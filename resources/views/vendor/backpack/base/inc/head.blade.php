<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if (config('backpack.base.meta_robots_content'))
<meta name="robots" content="{{ config('backpack.base.meta_robots_content', 'noindex, nofollow') }}">
@endif

{{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>
	{{ isset($title) ? isEnv().$title.' :: '.config('backpack.base.project_name').' Admin' : isEnv().config('backpack.base.project_name').' Admin' }}
</title>

@yield('before_styles')
@stack('before_styles')

<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.4.1 -->
{{--
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

--}}

<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">


{{--
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
--}}

<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bower_components/Ionicons/css/ionicons.min.css">

<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
<link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

<!-- BackPack Base CSS -->
<link rel="stylesheet" href="{{ asset('vendor/backpack/base/backpack.base.css') }}?v=3">

<!-- BackPack Base CSS -->
<link rel="stylesheet" href="{{ asset('vendor/backpack/base/backpack.base.css') }}?v=3">


<link rel="stylesheet" href="{{ asset('css/colors.css') }}">


<link rel="stylesheet" href="{{ asset('css/custom_2020.css') }}">

<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

@if (config('backpack.base.overlays') && count(config('backpack.base.overlays')))
    @foreach (config('backpack.base.overlays') as $overlay)
    <link rel="stylesheet" href="{{ asset($overlay) }}">
    @endforeach
@endif

<link rel="stylesheet" href="{{ asset('css/style-custom.css') }}">
@yield('after_styles')
@stack('after_styles')

<style>
    .headline {
        font-size: 23px;
        color: white;
        margin-top: 10px;
    }

    .skin-blue-light .main-header .navbar {
        background: linear-gradient(118deg, #495464, #495464);
    }

    .skin-blue-light .wrapper, .skin-blue-light .main-sidebar, .skin-blue-light .left-side {
        background-color: #ffff;
    }

    .content-wrapper {
        background-color: #ffff;
    }
</style>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
