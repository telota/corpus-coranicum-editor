@foreach ($mappings as $m)
    {{ str_pad($m['sura_start'], 3, 0, STR_PAD_LEFT) .
        ':' .
        str_pad($m['verse_start'], 3, 0, STR_PAD_LEFT) .
        ':' .
        str_pad($m['word_start'], 3, 0, STR_PAD_LEFT) .
        '-' .
        str_pad($m['sura_end'], 3, 0, STR_PAD_LEFT) .
        ':' .
        str_pad($m['verse_end'], 3, 0, STR_PAD_LEFT) .
        ':' .
        str_pad($m['word_end'], 3, 0, STR_PAD_LEFT) }}
    <br>
@endforeach
