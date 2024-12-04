<select name="{{ $label }}">

    @foreach($items as $key => $values)

        <option value="{{ $key }}" cite="{{ $values["short_cite"] }}">
            {{ $values["long"] }}
        </option>

    @endforeach

</select>