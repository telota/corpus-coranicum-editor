<td>

    @if(isset($link))
        <a href='{{$link}}'>
            {!! $text !!}
        </a>
    @else
        {!! $text !!}
    @endif

    @if(isset($editLink))

        <span class="pull-right">
                    @include('edit_button', [
                        'link' => $editLink,
                        'label' => ''
                    ])
        </span>
    @endif
</td>