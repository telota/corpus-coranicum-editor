@extends("layouts.master")

@section("title")

    <h1>
        Lesartkommentar zu Sure {{ $sure }}, Vers {{ $vers }}
        <a href="{{ URL::route("lesearten.editLeseartKommentar", [$sure, $vers]) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>

@endsection

@section("content")


    {!! $kommentar !!}

@endsection