@extends("layouts.master")

@section("title")

    <h1>New Role</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $role))

@endsection
