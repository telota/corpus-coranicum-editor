<select name="{{ $label }}">

    @foreach($items as $item)

        <option>
                {{ $item ['ID'] }}
                {{ $item ['Titel'] }}
        </option>

    @endforeach

</select>