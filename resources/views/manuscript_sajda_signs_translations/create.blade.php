@extends("layouts.master")

@section("title")

    {{ strip_tags($manuscript->getNameString()) }} - New Sajda Signs Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $sajdaSignsTranslation))

@endsection
