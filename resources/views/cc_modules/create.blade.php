@extends("layouts.master")

@section("title")

    <h1>New Module</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $module))

@endsection