@extends("layouts.master")

@section("title")

    <h1>Umwelttexte

        {{ (isset($sure)) ? " für Sure " . $sure : "" }}{{ (isset($vers)) ? ", Vers " . $vers : "" }}


        <a href="{{ URL::action([App\Http\Controllers\UmwelttexteController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>


    </h1>


        <div class="btn-group">
            <div class="dropdown btn-group">
                <button class="btn btn-default dropdown-toggle pull" type="button" id="surenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Sure {{ (isset($sure) ? $sure : "auswählen") }}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable" aria-labelledby="surenauswahl">
                    @for($i = 1; $i <= 114; $i++)

                        @if(isset($sure))
                            <li {{ ($i == $sure) ? 'class=active' : "" }}>
                                <a href="{{ URL::route("umwelttexte.index.sure", $i) }}">{{ $i }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ URL::route("umwelttexte.index.sure", $i) }}">{{ $i }}</a>
                            </li>
                        @endif

                    @endfor
                </ul>
            </div>

            @if(isset($sure))

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="versauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Vers {{ (isset($vers)) ? $vers : " auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="versauswahl">
                        @for($i = 1; $i <= $maxVers; $i++)

                            @if(isset($vers))
                                <li {{ ($i == $vers) ? 'class=active' : "" }}>
                                    <a href="{{ URL::route("umwelttexte.index.vers", array($sure, $i)) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ URL::route("umwelttexte.index.vers", array($sure, $i)) }}">{{ $i }}</a>
                                </li>
                            @endif

                        @endfor
                    </ul>

                </div>

            @endif

            <div class="dropdown btn-group">

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="sprachauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-flag"></span>
                        {{ (isset($lang)) ? $lang : "Sprache auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="versauswahl">

                        @foreach(\App\Models\Umwelttexte\Belegstelle::getAllLanguages() as $language)

                            @if(isset($lang))
                                <li {{ ($lang == $language) ? 'class=active' : "" }}>
                                    <a href="{{ URL::route("umwelttexte.index.language", urlencode($language)) }}">{{ $language }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ URL::route("umwelttexte.index.language", urlencode($language)) }}">{{ $language }}</a>
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>
            <div class="dropdown btn-group">

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="sprachauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{ (isset($kategorie)) ? $kategorie . ' : ' . \App\Models\Umwelttexte\BelegstellenKategorie::where('id',$kategorie)->get()[0]->name : "Kategorie auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="versauswahl">

                        @foreach(\App\Models\Umwelttexte\BelegstellenKategorie::all() as $kate)

                            @if(strlen($kate->id) < 2)
                                <h4 class="dropdown-header"><u><a href="{{ URL::route("umwelttexte.index.kategorie", $kate->id) }}">{{ $kate->id }} : {{ $kate->name }}</a></u></h4>
                            @else
                                    <li class='dropdown-item' . {{ isset($kategorie) ? (($kategorie == $kate->id) ? ' active' : "" ) : "" }}>
                                        <a href="{{ URL::route("umwelttexte.index.kategorie", $kate->id) }}">{{ $kate->id }} : {{ $kate->name }}</a>
                                    </li>
                            @endif
                        @endforeach

                    </ul>

                </div>
            </div>
        </div>


@endsection



@section("content")

    <table id="umwelttexte-table" class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Autor</th>
            <th>Sprache</th>

            @if(isset($sure) && (!(isset($vers))))

                <th>Textstellen</th>

            @endif

            <th>Chron.</th>
            {{--<th>Kategorie</th>--}}
            <th>Webtauglich</th>
            <th>Bearbeiter</th>
        </tr>
        </thead>
        <tbody>

        @foreach($umwelttexte as $umwelttext)

            <tr>
                <td>{{ $umwelttext->ID }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\UmwelttexteController::class, 'show'], $umwelttext->ID) }}">
                        {{ $umwelttext->Titel }}
                    </a>
                </td>
                <td>{{ $umwelttext->Autor }}</td>
                <td>{{ $umwelttext->Sprache }}</td>

                @if(isset($sure) && (!(isset($vers))))

                    <td class="no-bullets">
                        <ul>
                            @foreach($textstellen[$umwelttext->ID] as $stelle)
                            <li>{{ $stelle }}</li>
                            @endforeach
                        </ul>
                    </td>

                @endif

                <td>
                    {{ $umwelttext->chronology()["I"] }}-{{ $umwelttext->chronology()["II"] }}-{{ $umwelttext->chronology()["III"] }}-{{ $umwelttext->chronology()["IV"] }}
                </td>

                {{--<td>--}}
                    {{--{{ $umwelttext->kategorie }} {{ \App\Models\Umwelttexte\BelegstellenKategorie::find($umwelttext->kategorie) != null ? ' : ' . urldecode(\App\Models\Umwelttexte\BelegstellenKategorie::find($umwelttext->kategorie)->name) : '  ' }}--}}
                {{--</td>--}}

                <td>{{ $umwelttext->webtauglich }}</td>

                <td>
                    {{ (empty($umwelttext->Bearbeiter)) ? $umwelttext->lastAuthor : $umwelttext->Bearbeiter }}
                <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\UmwelttexteController::class, 'show'], $umwelttext->ID) }}"
                           title="Umwelttext anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\UmwelttexteController::class, 'edit'], $umwelttext->ID) }}"
                           title="Umwelttext bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>

                    </span>
                </td>
            </tr>


        @endforeach

        </tbody>

    </table>

@endsection