@extends("layouts.master")

@section("title")

    <h1>New Script</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $script))

@endsection
