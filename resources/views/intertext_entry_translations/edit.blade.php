@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">

        {{ strip_tags($intertext->getNameString()) }}

    </a> - {{ ucfirst($entryTranslation->language->translation_language) }} Entry

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $entryTranslation))

@endsection
