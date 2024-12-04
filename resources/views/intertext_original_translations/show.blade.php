@extends("layouts.master")
<?php $intertext = $originalTranslation->intertext; ?>
@section("title")
    <h1>
        {{ ucfirst($originalTranslation->language->translation_language) . " Reference Original Text - "    }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
           {{ $intertext->getNameString()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'edit'], $originalTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Intertext ID</span>
            {!! $originalTranslation->intertext_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $originalTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $originalTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $originalTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $originalTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $originalTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $originalTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $originalTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Other Translator</span>
            {!! $originalTranslation->source_text_translation_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Reference Translation Source Text</span>
            {!! $originalTranslation->source_text_translation !!}
        </li>
    </ul>

@endsection
