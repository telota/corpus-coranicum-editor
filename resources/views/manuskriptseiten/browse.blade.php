{{-- <div class="flex-container"> --}}
<div class="btn-toolbar">

    <div class="btn-group">
        @if($manuskriptseite->nextManuskriptseite)
            <a href="{{ URL::action([App\Http\Controllers\ManuskriptseitenController::class, 'show'], $manuskriptseite->nextManuskriptseite->SeitenID) }}" class="btn btn-default">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Next: Folio {{ $manuskriptseite->nextManuskriptseite->Folio }}{{ $manuskriptseite->nextManuskriptseite->Seite }}
            </a>
        @endif

        @if($manuskriptseite->previousManuskriptseite)
            <a href="{{ URL::action([App\Http\Controllers\ManuskriptseitenController::class, 'show'], $manuskriptseite->previousManuskriptseite->SeitenID) }}" class="btn btn-default">
                Previous: Folio {{ $manuskriptseite->previousManuskriptseite->Folio }}{{ $manuskriptseite->previousManuskriptseite->Seite }}
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        @endif
    </div>


        @if($manuskriptseite->manuskript->getManuscriptPagesAndIds())
            <div class="btn-group"
                 id="vue-ms-page-select">
                <manuskriptseiten-select
                    :folios="{{ $manuskriptseite->manuskript->getManuscriptPagesAndIds() }}"
                    current="{{ $manuskriptseite->SeitenID }}"
                    urlbase="{{ urldecode(URL::action([App\Http\Controllers\ManuskriptseitenController::class, 'show'],
                    ["id"=> "page_id"]
                    )) }}"
                    />
            </div>
        @endif


    @if(in_array($manuskriptseite->webtauglich, array("ja", "ohneBild")) && $manuskriptseite->corpusCoranicumLink)
        <div class="btn-group">
            <a href="{{ $manuskriptseite->corpusCoranicumLink }}" class="btn btn-success" target="_blank">
                <span class="glyphicon glyphicon-globe"></span>
                Open on Corpus Coranicum
            </a>
        </div>
    @endif

</div>

