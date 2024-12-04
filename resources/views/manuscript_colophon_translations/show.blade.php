@extends("layouts.master")
<?php $manuscript = $colophonTranslation->manuscript; ?>
@section("title")
    <h1>
        {{ ucfirst($colophonTranslation->language->translation_language) . " Entry - "    }}
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">
           {{ $manuscript->getNameString()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'edit'], $colophonTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Manuscript ID</span>
            {!! $colophonTranslation->manuscript_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $colophonTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $colophonTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $colophonTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $colophonTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $colophonTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $colophonTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $colophonTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Colophon Text Translation Reference</span>
            {!! $colophonTranslation->colophon_text_translation_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Colophon Text Translation</span>
            {!! $colophonTranslation->colophon_text_translation !!}
        </li>
    </ul>

@endsection
