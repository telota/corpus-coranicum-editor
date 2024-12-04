@extends("layouts.master")

@section("title")

    {{ strip_tags($category->getFullNameAttribute()) }} - New Category Information Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
