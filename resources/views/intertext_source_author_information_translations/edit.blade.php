@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([IntertextSourceAuthorController::class, 'show'], $sourceAuthor->id) }}">

        {{ strip_tags($sourceAuthor->author_name) }}

    </a> - {{ ucfirst($infoTranslation->language->translation_language) }} Source Author Information Text

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
