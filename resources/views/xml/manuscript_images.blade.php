<images>
    @foreach($images as $i)
        <image mysql_id='{{$i->id}}' sharable='{{$i->private_use_only ? "false" : "true"}}'>
            @php($archive=$i->page->manuscript->place)
            @if(isset($archive))
                <archive mysql_id='{{$archive->id}}'
                         name='{{$archive->place_name}}'
                         location='{{$archive->place}}, {{$archive->country_code}}' />
            @endif
            @php($m=$i->page->manuscript)
            <manuscript mysql_id='{{$m->id}}' call_number='{{$m->call_number}}' />
            @php($p=$i->page)
            <page mysql_id='{{$p->id}}' folio='{{$p->folio}}' page_side='{{$p->page_side}}' />
            <path>{{$i->image_link}}</path>
        </image>

    @endforeach
</images>