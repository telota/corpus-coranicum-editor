<div name='quran-mapping'>
    <hr>
    @foreach (['start', 'end'] as $limit)
        <x-form.quran-coordinate
                :limit='$limit'
                :sura="$m['sura_' . $limit]"
                :verse="$m['verse_' . $limit]"
                :word="$m['word_' . $limit]"
                :$withWord
        />
    @endforeach
    @include('delete_button', ['name' => 'delete-quran-mapping', 'text' => 'Remove Passage'])
    <hr>
</div>