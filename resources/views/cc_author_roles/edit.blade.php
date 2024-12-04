@extends("layouts.master")

@section("title")

    <h1>{{'Rolle für ' . $author->author_name . ' bearbeiten' }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $authorRole))

@endsection
