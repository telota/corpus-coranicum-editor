@extends("layouts.master")

@section("title")

    {{ strip_tags($intertext->getNameString()) }} - New Entry Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $entryTranslation))

@endsection
