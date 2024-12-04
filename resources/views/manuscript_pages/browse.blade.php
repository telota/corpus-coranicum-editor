@if(($page->is_online) && $page->manuscript->is_online)
    <div class="btn-group">
        <a href="{{ $page->corpusCoranicumLink }}" class="btn btn-success" target="_blank">
            <span class="glyphicon glyphicon-globe"></span>
            Open on Corpus Coranicum
        </a>
    </div>
    <br>
    <br>
@endif
@if(sizeof($page->manuscript->manuscriptPages)>1)
    <h4>Other pages:</h4>
@endif
@foreach($page->manuscript->manuscriptPages as $p)
        @if($page->id !== $p->id)
            <a href='{{route('ms_page.show', ["manuscript_id"=>$p->manuscript_id, "page_id"=>$p->id])}}'>
                {{$p->folio . $p->page_side}}
            </a>
        @else
            {{$p->folio . $p->page_side}}
        @endif
    @endforeach