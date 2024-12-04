@extends("layouts.master")

@section("title")

    {{ strip_tags($intertext->getNameString()) }} - New Original Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $originalTranslation))

@endsection
