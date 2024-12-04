@extends("layouts.master")

@section("title")

    <h1>
<!--        --><?php //dd(gettype($intertext->getNameString()));?>
        {{ "Intertext ID: " . strip_tags($intertext->id) }}
    </h1>

@endsection

@section("content")
    @include("intertexts.create_update", array(
        "record" => $intertext,
        "action" => $action
    ))

{{--    <hr>--}}

{{--    <h2>Paret & Transliteration</h2>--}}

{{--    <div id="paret-transliteration"></div>--}}

@endsection

@section("js")

    <script type="text/javascript">
        var maxVerses = {!! App\Models\Sure::getMaxVerse() !!};
        var maxWords = {!! App\Models\Sure::getMaxWords() !!};

        // Get paret translations and transliterations
        // getParetTransliteration();
    </script>

@endsection
