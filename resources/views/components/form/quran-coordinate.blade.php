<div class="form-horizontal">
    <div class="form-group" name="quran-coordinate-{{ $limit }}">
        <div style="width:70px;display:inline-block">
            <strong>{{ ucfirst($limit) }}</strong>
        </div>
        <label for='{{ "sura_{$limit}[]" }}'>Sura:</label>
        <select name='{{ "sura_{$limit}[]" }}' style="width:60px">
            @foreach (range(1, 114) as $s)
                <option value="{{ $s }}" @if ($s == $sura) selected @endif>
                    {{ $s }}
                </option>
            @endforeach
        </select>
        <label for='{{ "verse_{$limit}[]" }}'>Verse:</label>
        <select name='{{ "verse_{$limit}[]" }}' style="width:60px">
            @foreach (range(0, 286) as $v)
                <option value="{{ $v }}" @if ($v == $verse) selected @endif>
                    {{ $v }}
                </option>
            @endforeach
        </select>
        @if($withWord)
            <label for='{{ "word_{$limit}[]" }}'>Word:</label>
            <select name='{{ "word_{$limit}[]" }}' style="width:120px">
                @foreach (range(-1, 128) as $w)
                    <option value="{{ $w }}"
                            @if ((isset($word) && $w == $word) || ($word === null && $w == -1) || ($word == 999 && $w == -1))
                                selected
                            @endif
                    >
                        {{ $w == -1 ? 'No Word Selected' : $w }}
                    </option>
                @endforeach
            </select>
            <span class="arab arab-word">&nbsp;</span>
        @endif
    </div>
</div>