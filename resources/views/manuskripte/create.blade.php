@extends("layouts.master")

@section("title")

    Neues Manuskript

@endsection


@section("content")

    @include("includes.create_update", array(
    "record" => $manuskript))

@endsection
