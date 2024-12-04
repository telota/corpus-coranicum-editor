@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">

        {{ strip_tags($intertext->getNameString()) }}

    </a> - {{ ucfirst($originalTranslation->language->translation_language) }} Reference Original Text

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $originalTranslation))

@endsection
