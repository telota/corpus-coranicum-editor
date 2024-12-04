@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            Quran Coordinates
        </td>
        <td>
            @foreach($mappings as $index => $m)
                {{$m->getReadableCoordinatesAttribute()}}
                <br>
            @endforeach
        </td>
    </tr>
@else
    <div id="quran-mappings-edit">
        <h3>
            Quran Coordinates
        </h3>
        @foreach ($mappings as $m)
            <x-form.quran-mapping :$m :withWord='true' />
        @endforeach
        <x-add-button id='new-mapping' text='Add Quran Passage' />
        <br>
        <br>
        <hr>
    </div>
@endif