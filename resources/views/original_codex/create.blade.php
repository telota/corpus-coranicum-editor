@extends("layouts.master")

@section("title")

    <h1>Original Codex erstellen</h1>

@endsection

@section("content")

    @include("original_codex.create_update", array(
    "manuskriptOriginalCodex" => $manuskriptOriginalCodex,
    "superKategorien" => $superKategorien
    ))

@endsection
