@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">

        {{ strip_tags($manuscript->getNameString()) }}

    </a> - {{ ucfirst($colophonTranslation->language->translation_language) }} Colophon

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $colophonTranslation))

@endsection
