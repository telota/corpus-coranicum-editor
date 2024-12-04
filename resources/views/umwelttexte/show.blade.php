@extends("layouts.master")

@section("title")

    <h1>
        {{ $umwelttext->Titel }}

        <a href="{{ URL::action([App\Http\Controllers\UmwelttexteController::class, 'edit'], $umwelttext->ID) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>

@endsection


@section("content")

    <h2>Textstellen</h2>

    @foreach($koranstellenChrono as $chrono => $koranstellen)
        @unless(empty($koranstellen))
            <li>{{ $chrono }}: {{ $koranstellen }}</li>
        @endunless
    @endforeach

    <hr>
    <h2>Metadaten</h2>

    @include("includes.metadata", array(
        "record" => $umwelttext
    ))
    
    <h2>Bilder</h2>
    
    @foreach($umwelttext->images as $image)
        <div>
            <figure>
                <a href="{{ Config::get("constants.digilib.scaler") . $image->bildlink . "&mo=ascale,1"}}">
                    <img src="{{ Config::get("constants.digilib.scaler") . $image->bildlink . "&mo=ascale,1"}}" alt="">
                </a>
                <figcaption>{{ $image->bildnachweis }}</figcaption>
            </figure>
        </div>
    @endforeach



@endsection