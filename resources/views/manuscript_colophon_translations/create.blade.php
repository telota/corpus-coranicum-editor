@extends("layouts.master")

@section("title")

    {{ strip_tags($manuscript->getNameString()) }} - New Colophon Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $colophonTranslation))

@endsection
