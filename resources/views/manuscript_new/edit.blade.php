@extends("layouts.master")

@section("title")
    <h1>
        {{ $manuskript->getName() }}
    </h1>
@endsection

@section("content")
@include("manuscript_new.create_update", array(
"record" => $manuskript))
@endsection
