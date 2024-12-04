@extends("layouts.master")

@section("title")

    <h1>Category erstellen</h1>

@endsection

@section("content")

    {{--    @include("intertext_categories.create_update", array(--}}
    {{--    "intertextCategory" => $intertextCategory--}}
    {{--    ))--}}

    @include("includes.create_update", array(
    "record" => $intertextCategory))

@endsection
