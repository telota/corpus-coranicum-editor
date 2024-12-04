@extends("layouts.master")

@section("title")

    {{ strip_tags($manuskript->Kodextitel) }} - Neue Manuskriptseite

@endsection


@section("content")

    @include("includes.create_update", array(
    "record" => $manuskriptseite))

@endsection

@section("js")

    <script type="text/javascript">
        var maxVerses = {!! App\Models\Sure::getMaxVerse() !!};
        var maxWords = {!! App\Models\Sure::getMaxWords() !!};
    </script>

@endsection
