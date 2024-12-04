@extends("layouts.master")

@section("title")


    <h1>
        Koranübersetzungen (Paret)

        {{ isset($sure) ? " - Sure " . $sure : "" }} {{ isset($sprache) ? " - Sprache " . $sprache : "- Sprache: de" }}

    </h1>

    <div class="btn-group">
        <div class="dropdown btn-group">
            <button class="btn btn-default dropdown-toggle pull" type="button" id="surenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Sure {{ (isset($sure) ? $sure : "auswählen") }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu scrollable" aria-labelledby="surenauswahl">

                @if(isset($sprache))
                    <li>
                        <a href="{{ URL::route("druckausgabe.index.all.sprache", $sprache) }}">Alle</a>
                    </li>
                @else
                    <li>
                        <a href="{{ URL::route("druckausgabe.index.all.de", [null, 'de']) }}">Alle</a>
                    </li>
                @endif

                @for($i = 1; $i <= 114; $i++)

                    @if(isset($sprache))
                        <li {{ ($i == $sure) ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.sure.sprache", [$i, $sprache]) }}">{{ $i }}</a>
                        </li>
                    @else
                        <li {{ ($i == $sure) ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.sure.de", [$i, 'de']) }}">{{ $i }}</a>
                        </li>
                    @endif

                @endfor
            </ul>
        </div>
    </div>

    <div class="btn-group">
        <div class="dropdown btn-group">
            <button class="btn btn-default dropdown-toggle pull" type="button" id="sprachenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Sprache {{ (isset($sprache) ? $sprache : "auswählen") }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu scrollable" aria-labelledby="sprachenauswahl">

                @foreach($sprachen as $sprache_item)

                    @if(isset($sure) && isset($sprache))
                        <li {{ ($sprache_item == $sprache) ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.sure.sprache", [$sure, $sprache_item]) }}">{{ $sprache_item }}</a>
                        </li>
                    @elseif(!isset($sure) && isset($sprache))
                        <li {{ ($sprache_item == $sprache) ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.all.sprache", $sprache_item) }}">{{ $sprache_item }}</a>
                        </li>
                    @elseif(isset($sure) && !isset($sprache))
                        <li {{ ($sprache_item == 'de') ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.sure.sprache", [$sure, $sprache_item]) }}">{{ $sprache_item }}</a>
                        </li>
                    @else
                        <li {{ ($sprache_item == 'de') ? 'class=active' : "" }}>
                            <a href="{{ URL::route("druckausgabe.index.all.sprache", $sprache_item) }}">{{ $sprache_item }}</a>
                        </li>
                    @endif

                @endforeach
            </ul>
        </div>

@endsection

@section("content")

        <table id="paret-table" class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>Sure</th>
            <th>Vers</th>
            <th>Inhalt</th>
        </tr>
        </thead>

        <tbody>

        @foreach($translations as $translation)

            <tr>
                <td>{{ $translation->sure }}</td>
                <td>{{ $translation->vers }}</td>
                <td>{{ str_limit($translation->text, 75) }}


                    <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\DruckausgabeController::class, 'showByVerse'], [$translation->sure, $translation->vers]) }}"><span class="glyphicon glyphicon-hover glyphicon-eye-open"></span></a>
                        <a href="{{ URL::action([App\Http\Controllers\DruckausgabeController::class, 'editByVerse'], [$translation->sure, $translation->vers]) }}"><span class="glyphicon glyphicon-hover glyphicon-pencil"></span></a>


                    </span>
                </td>
            </tr>

        @endforeach

        </tbody>

    </table>


@endsection