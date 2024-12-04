@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $source->id) }}">

        {{ strip_tags($source->source_name) }}

    </a> - {{ ucfirst($infoTranslation->language->translation_language) }} Source Information Text

@endsection
@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
