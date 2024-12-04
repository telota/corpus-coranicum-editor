<ul class="list-group">

    <?php

        $a = $record->toArray();
        ksort($a);

    ?>

    @foreach($a as $label => $content)

        @unless(empty($content))
            <li class="list-group-item">

                <!-- TODO Problem here http://cc-edit.lar/manuskript/show/57 -->
                <span class="label label-default">{{$label}}</span>

                @if(is_array($content))
                    ARRAY
                @else
                {!! $content !!}
                @endif


            </li>
        @endunless

    @endforeach
</ul>
