@extends("layouts.master")

@section("title")

    <h1> {{'Neue Rolle für '. $author->author_name}}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $authorRole))

@endsection
