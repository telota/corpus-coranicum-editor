@extends("layouts.master")

@section("title")

    {{ strip_tags($manuscript->getNameString()) }} - New Palimpsest Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $palimpsestTranslation))

@endsection
