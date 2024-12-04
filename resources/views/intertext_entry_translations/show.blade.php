@extends("layouts.master")
<?php $intertext = $entryTranslation->intertext; ?>
@section("title")
    <h1>
        {{ ucfirst($entryTranslation->language->translation_language) . " Entry - "    }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
           {{ $intertext->getNameString()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'edit'], $entryTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Intertext ID</span>
            {!! $entryTranslation->intertext_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $entryTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $entryTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $entryTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $entryTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $entryTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $entryTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $entryTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Entry</span>
            {!! $entryTranslation->entry_translation !!}
        </li>
    </ul>

@endsection
