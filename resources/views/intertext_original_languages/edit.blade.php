@extends("layouts.master")

@section("title")

    <h1>{{ $language->original_language  }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $language))

@endsection