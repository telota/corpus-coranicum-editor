@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">

        {{ strip_tags($manuscript->getNameString()) }}

    </a>
    - Folio {{ $manuscriptPage->folio . $manuscriptPage->page_side }}

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptPageController::class, 'edit'], $manuscriptPage->id) }}">
        <span class="glyphicon glyphicon-pencil glyphicon-hover"
        title="Manuskriptseite bearbeiten"></span>
    </a>

@endsection

@section("content")

    @include("manuscript_pages.browse")

    <hr>


    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">ID</span>
            {!! $manuscriptPage->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Folio</span>
            {!! $manuscriptPage->folio !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Seite</span>
            {!! $manuscriptPage->page_side !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Textstellen</span>
            {!! $manuscriptPage->extractTextstelle() !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Manuscript ID</span>
            {!! $manuscriptPage->manuscript_id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $manuscriptPage->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $manuscriptPage->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $manuscriptPage->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $manuscriptPage->updated_at !!}
        </li>
    </ul>

    @include("includes.manuscript-pages.show-images")

{{--    <hr>--}}

{{--    @include("transliteration.show")--}}

    <hr>

    @include("manuscript_pages.browse")

    <hr>

@endsection

@section("scripts")
    <script src="{{ URL::asset("assets/js/manuskriptseiten-select.js") }}"></script>
@endsection
