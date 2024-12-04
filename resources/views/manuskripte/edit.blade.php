

@extends("layouts.master")

@section("title")

    {{ strip_tags($manuskript->Kodextitel) }} (ID: {{ $manuskript->ID }})
@endsection


@section("content")

    @include("includes.create_update", array(
    "record" => $manuskript))


@endsection
