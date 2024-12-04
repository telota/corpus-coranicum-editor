@extends("layouts.master")

@section("title")

    <h1>{{ $author->author_name  }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $author))

@endsection
