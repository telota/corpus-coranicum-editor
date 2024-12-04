@extends("layouts.master")

@section("title")

    <h1>{{ $role->role_name  }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $role))

@endsection
