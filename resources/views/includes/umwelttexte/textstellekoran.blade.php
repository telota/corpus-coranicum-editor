<div class="panel panel-default" id="quran-mappings-edit">
    <div class="panel-heading">Textstelle Koran</div>
    <div class="panel-body">
        @foreach($umwelttext->koranstellen as $mapping)
            @php($m=\App\Models\Umwelttexte\Belegstelle::makeEnglishLanguageMapping($mapping))
            <x-form.quran_mapping :$m :withWord='false' />
        @endforeach
        <x-add-button id='new-verse-mapping' text='Add Quran Passage' />
    </div>
</div>