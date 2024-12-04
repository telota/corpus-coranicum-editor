@extends("layouts.master")

@section("title")

    {{ strip_tags($source->source_name) }} - New Source Information Translation

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
