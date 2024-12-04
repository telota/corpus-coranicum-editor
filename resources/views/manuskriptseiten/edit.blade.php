@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuskriptController::class, 'show'], $manuskript->ID) }}">

        {{ strip_tags($manuskript->Kodextitel) }}

    </a> - Folio {{ $manuskriptseite->Folio . $manuskriptseite->Seite }}

@endsection


@section("content")

    @include("includes.create_update", array(
    "record" => $manuskriptseite))

    <hr>

    <h2>Transliteration</h2>

    {{--

    {!! Form::textarea("transliteration", null, array("id" => "transliteration")) !!}

    --}}

@endsection

@section("js")

    <script type="text/javascript">
        var maxVerses = {!! App\Models\Sure::getMaxVerse() !!};
        var maxWords = {!! App\Models\Sure::getMaxWords() !!};
    </script>

@endsection
