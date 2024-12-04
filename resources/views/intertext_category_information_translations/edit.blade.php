@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'show'], $category->id) }}">

        {{ strip_tags($category->getFullNameAttribute()) }}

    </a> - {{ ucfirst($infoTranslation->language->translation_language) }} Category Information Text

@endsection

@section("content")

    @include("includes.create_update", array(
    "record" => $infoTranslation))

@endsection
