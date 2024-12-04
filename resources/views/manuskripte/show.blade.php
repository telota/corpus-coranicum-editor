@extends('layouts.master')

@section('title')
    {{ strip_tags($manuskript->Kodextitel) }}
@endsection

@section('content')
    @if (in_array($manuskript->webtauglich, ['ja', 'ohneBild']) && $manuskript->corpusCoranicumLink)
        <div class="flex-container">

            <a href="{{ $manuskript->corpusCoranicumLink }}" class="btn btn-success flex-item" target="_blank">
                <span class="glyphicon glyphicon-globe"></span>
                Open on Corpus Coranicum
            </a>

        </div>
        <hr>
    @endif



    @include('includes.metadata', ['record' => $manuskript])



    @if (!in_array($manuskript->ID, App\Models\Manuskripte\Manuskript::getProtectedManuscripts()))
        <div id="publish-manuskript-root">

            <h2>Status:

                @if($manuskript->webtauglich == "ja")
                    Online
                @elseif($manuskript->webtauglich == "ohneBild")
                    Online ohne Bilder
                @else
                    Offline
                @endif
            </h2>

        </div>
    @endif

    <hr>

    <h2>
        Manuskriptseiten
    </h2>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>Folio</th>
            <th>Seite</th>
            <th>Textstelle</th>
            <th>Webtauglich</th>
        </tr>
        </thead>

        @foreach ($manuskript->manuskriptseiten as $seite)
            <tr>
                <td>{{ $seite->Folio }}</td>
                <td>
                    {{ $seite->Seite }}
                </td>
                <td>
                    {{ $seite->TextstelleKoran }}

                </td>
                <td>
                    {{ strip_tags($seite->webtauglich) }}
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\ManuskriptseitenController::class, 'show'], $seite->SeitenID) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                  title="Manuskriptseite anzeigen"></span>
                        </a>

                        @if ($seite->Bildlink)
                            <a href="{{ Config::get('constants.digilib.full') . $seite->BildPath }}">
                                <span class="glyphicon glyphicon-picture glyphicon-hover"
                                      title="Bild ansehen (Hohe Auflösung)"></span>
                            </a>
                        @endif

                        @if ($seite->Bildlink2)
                            <a href="{{ Config::get('constants.digilib.full') . $seite->BildPath2 }}">
                                <span class="glyphicon glyphicon-picture glyphicon-hover" title="Bild 2 ansehen"></span>
                            </a>
                        @endif

                    </span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
