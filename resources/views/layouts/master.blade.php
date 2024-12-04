<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="robots" content="noindex">


    <link rel="stylesheet" href="{{ URL::asset("assets/css/bundle.css") }}">
    <link rel="stylesheet" href="{{ URL::asset("assets/css/app.css") }}">
    <link rel="stylesheet" href="{{ URL::asset("assets/css/bootstrap-styling.css") }}">

    @yield("js")


</head>
<body class="@yield("body-class")">
@if(Auth::check())
    @include("includes.header")
@endif

@yield("sidebar")


<div class="container @yield("container-class")">

    @if (Session::has("flash_message"))
        <div class="alert {{ Session::get("flash_type") }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get("flash_message") }}
        </div>
    @endif

    <div class="back">
        @yield("back")
    </div>

    <div class="page-header">
            @yield("title")
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield("content")
</div>


<div class="footer navbar navbar-default" style="margin-bottom: 0px;">
    <div class="container">
        <ul class="nav navbar-nav">
            <li><a href="https://www.bbaw.de/datenschutz">Datenschutzerklärung</a></li>
        </ul>
    </div>
</div>

<script src="{{ URL::asset("assets/js/bundle.js") }}"></script>
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script src="{{ URL::asset('assets/js/main-typescript.js') }}"></script>

@yield("scripts")

</body>

</html>
