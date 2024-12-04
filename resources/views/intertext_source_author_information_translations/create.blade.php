@extends("layouts.master")

@section("title")

    {{ strip_tags($sourceAuthor->author_name) }} - New Source Author Information Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
