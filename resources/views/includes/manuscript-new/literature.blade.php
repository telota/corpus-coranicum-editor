@if(count($zoteroItems) > 0)
<ul>
    @foreach($zoteroItems as $zoteroItem)

        <li>{{$zoteroItem}}</li>

    @endforeach
</ul>
@endif
