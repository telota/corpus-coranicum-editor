@extends("layouts.master")

@section("title")

    <h1>New Translation Language</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $language))

@endsection
