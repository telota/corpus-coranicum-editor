@extends("layouts.master")

@section("title")

    <h1>
        {{ empty($leser->anzeigename) ? "Neuer Leser" : $leser->anzeigename }}
    </h1>

@endsection

@section("content")

    @include("includes.create_update", array(
        "record" => $leser))

@endsection