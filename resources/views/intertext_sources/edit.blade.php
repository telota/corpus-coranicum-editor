@extends("layouts.master")

@section("title")

    <h1>{{ $source->source_name  }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $source))

@endsection
