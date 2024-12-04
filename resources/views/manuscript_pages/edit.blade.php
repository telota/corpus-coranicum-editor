@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">

        {{ strip_tags($manuscript->getNameString()) }}

    </a> - Folio {{ $manuscriptPage->folio . $manuscriptPage->page_side }}

@endsection


@section("content")

    @include("includes.create_update", array(
    "record" => $manuscriptPage))

@endsection

@section("js")

    <script type="text/javascript">
        var maxVerses = {!! App\Models\Sure::getMaxVerse() !!};
        var maxWords = {!! App\Models\Sure::getMaxWords() !!};
    </script>

@endsection
