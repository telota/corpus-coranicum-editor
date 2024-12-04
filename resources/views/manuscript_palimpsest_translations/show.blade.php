@extends("layouts.master")
<?php $manuscript = $palimpsestTranslation->manuscript; ?>
@section("title")
    <h1>
        {{ ucfirst($palimpsestTranslation->language->translation_language) . " Entry - "    }}
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">
           {{ $manuscript->getNameString()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptPalimpsestTranslationController::class, 'edit'], $palimpsestTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Manuscript ID</span>
            {!! $palimpsestTranslation->manuscript_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $palimpsestTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $palimpsestTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $palimpsestTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $palimpsestTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $palimpsestTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $palimpsestTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $palimpsestTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Palimpsest Text Translation Reference</span>
            {!! $palimpsestTranslation->palimpsest_text_translation_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Palimpsest Text Translation</span>
            {!! $palimpsestTranslation->palimpsest_text_translation !!}
        </li>
    </ul>

@endsection
