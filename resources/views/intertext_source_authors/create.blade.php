@extends("layouts.master")

@section("title")

    <h1>New Source Author</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $author))

@endsection