@extends("layouts.master")

@section("title")

    <h1>
        {{ (empty($umwelttext->Titel)) ? "Neuer Umwelttext" : $umwelttext->Titel }}
    </h1>

@endsection

@section("content")

    @include("includes.create_update", array(
        "record" => $umwelttext,
        "action" => $action,
    ))

    <hr>

    <h2>Paret & Transliteration</h2>

    <div id="paret-transliteration"></div>


@endsection