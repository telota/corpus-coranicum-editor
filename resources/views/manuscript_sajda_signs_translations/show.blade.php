@extends("layouts.master")
<?php $manuscript = $sajdaSignsTranslation->manuscript; ?>
@section("title")
    <h1>
        {{ ucfirst($sajdaSignsTranslation->language->translation_language) . " Entry - "    }}
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">
           {{ $manuscript->getNameString()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptSajdaSignsTranslationController::class, 'edit'], $sajdaSignsTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Manuscript ID</span>
            {!! $sajdaSignsTranslation->manuscript_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $sajdaSignsTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $sajdaSignsTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $sajdaSignsTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $sajdaSignsTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $sajdaSignsTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $sajdaSignsTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $sajdaSignsTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Sajda Signs Text Translation Reference</span>
            {!! $sajdaSignsTranslation->sajda_signs_text_translation_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Sajda Signs Text Translation</span>
            {!! $sajdaSignsTranslation->sajda_signs_text_translation !!}
        </li>
    </ul>

@endsection
