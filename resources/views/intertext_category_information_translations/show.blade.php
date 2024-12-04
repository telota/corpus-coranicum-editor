@extends("layouts.master")
<?php $category = $infoTranslation->category; ?>

@section("title")
    <h1>
        {{ ucfirst($infoTranslation->language->translation_language) . " Reference Original Text - "    }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'show'], $category->id) }}">
           {{ $category->getFullNameAttribute()  }}
        </a>
        <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'edit'], $infoTranslation->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $source))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Category ID</span>
            {!! $infoTranslation->category_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language ID</span>
            {!! $infoTranslation->language_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language</span>
            {!! $infoTranslation->language->translation_language !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $infoTranslation->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $infoTranslation->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $infoTranslation->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $infoTranslation->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Translator</span>
            {!! $infoTranslation->translator->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Information Translation Reference</span>
            {!! $infoTranslation->information_translation_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Information Translation Text</span>
            {!! $infoTranslation->information_translation !!}
        </li>
    </ul>

@endsection
