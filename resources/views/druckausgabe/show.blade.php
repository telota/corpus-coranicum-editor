@extends("layouts.master")

@section("title")

    <h1>Paret-Übersetzung (Sure {{ $translations[0]->sure }}, Vers {{ $translations[0]->vers }})

        <a href="{{ URL::action([App\Http\Controllers\DruckausgabeController::class, 'editByVerse'], [$translations[0]->sure, $translations[0]->vers]) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"
          title="Übersetzung bearbeiten"></span>
        </a>
    </h1>

@endsection

@section("content")


    @foreach($translations as $tanzilTranslation)

        @include("includes.metadata", array("record" => $tanzilTranslation))

    @endforeach

@endsection