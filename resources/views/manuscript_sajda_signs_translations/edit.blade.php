@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">

        {{ strip_tags($manuscript->getNameString()) }}

    </a> - {{ ucfirst($sajdaSignsTranslation->language->translation_language) }} Sajda Signs

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $sajdaSignsTranslation))

@endsection
