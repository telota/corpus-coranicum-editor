@extends("layouts.master")

@section("title")

<h1>Lesarten zu Sure {{ $sure }}, Vers {{ $vers }}

    <a href="{{ URL::route("lesearten.koranstellen.create", array($sure, $vers)) }}">
        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
    </a>

</h1>

@endsection

@section("content")

    @include("includes.leseart.leseartenTable")

@endsection