@extends("layouts.master")

@section("title")

    <h1>
        {{ "Neuer Umwelttext" }}
    </h1>

@endsection

@section("content")
    @include("intertexts.create_update", array(
        "record" => $intertext,
        "action" => $action
    ))
@endsection


