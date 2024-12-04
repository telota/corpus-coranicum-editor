@extends("layouts.master")

@section("title")

    <a href="{{ URL::action([App\Http\Controllers\ManuskriptController::class, 'show'], $manuskript->ID) }}">

        {{ strip_tags($manuskript->Kodextitel) }}

    </a>
    - Folio {{ $manuskriptseite->Folio . $manuskriptseite->Seite }}

@endsection

@section("content")

    @include("manuskriptseiten.browse")

    <hr>

    @include("includes.metadata", array("record" => $manuskriptseite))

    @include("includes.manuskriptseiten.show-images")

{{--    <hr>--}}

{{--    @include("transliteration.show")--}}

{{--    <hr>--}}

{{--    @include("paleocoran.manuskriptseiten.variant-readings.show")--}}

{{--    <hr>--}}

{{--    @include("paleocoran.manuskriptseiten.variant-orthography.show")--}}

{{--    <hr>--}}

{{--    @include("paleocoran.manuskriptseiten.verse-separators.show")--}}

    <hr>

    @include("manuskriptseiten.browse")

    <hr>

@endsection
