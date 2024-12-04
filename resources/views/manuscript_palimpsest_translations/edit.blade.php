@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">

        {{ strip_tags($manuscript->getNameString()) }}

    </a> - {{ ucfirst($palimpsestTranslation->language->translation_language) }} Palimpsest

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $palimpsestTranslation))

@endsection
