@extends("layouts.master")

@section("title")

    <h1>{{ $module->module_name  }}</h1>

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $module))

@endsection
