@extends("layouts.master")

@section("title")

    <h1>
        {{ $intertext->getNameString() }}

        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'edit'], $intertext->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>

@endsection


@section("content")

    <h2>Textstellen</h2>

    @foreach($koranstellenChrono as $chrono => $koranstellen)
        @unless(empty($koranstellen))
            <li>{{ $chrono }}: {{ $koranstellen }}</li>
        @endunless
    @endforeach

    <hr>
    <h2>Metadaten</h2>

{{--    @include("includes.metadata", array(--}}
{{--        "record" => $intertext--}}
{{--    ))--}}
    <?php $onlineString = array(2 => "ja", 1 => "Webtauglich (ohne Bild)", 0 => "nein");
    ?>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Intertext ID</span>
            {!! $intertext->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Intertext Date</span>
            {!! $intertext->intertext_date_start . ' - ' . $intertext->intertext_date_end !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Category</span>
            {!! $intertext->getFullCategoryNameAttribute() !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Text Edition</span>
            {!! $intertext->source_text_edition !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Explanation About Edition</span>
            {!! $intertext->explanation_about_edition !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">TUK Reference</span>
            {!! $intertext->tuk_reference !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">DOI</span>
            {!! $intertext->doi !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Online</span>
            {!! $onlineString[$intertext->is_online] !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $intertext->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $intertext->updated_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Published At</span>
            {!! $intertext->published_at !!}
        </li>
    </ul>


    <h3>
        Authors
    </h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Authors</span>
            {!! implode(", ", $intertext->getAuthors()) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">In Collaboration with</span>
            {!! implode(", ", $intertext->getCollaborators()) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updaters</span>
            {!! implode(", ", $intertext->getUpdaters()) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Text Editing</span>
            {!! implode(", ", $intertext->getTextEditing()) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $intertext->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $intertext->updated_by !!}
        </li>
    </ul>

    <h3>
        Entry
        <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'create'], $intertext->id) }}"
           title="Neue Entry Translation hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Entry</span>
            {!! $intertext->entry !!}
        </li>
        <h5>Translations:</h5>
        @foreach($intertext->entryTranslations as $entry)
            <?php $language = $entry->language->translation_language?>
            <li class="list-group-item">
                <span class="label label-default">{{ ucfirst($language) }} Entry</span>
                {!! $entry->entry_translation !!}
                <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'show'], $entry->id) }}"
                   title="Entry anzeigen">
                    <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                </a>
                <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'edit'], $entry->id) }}">
                    <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                </a>
            </li>
        @endforeach
    </ul>

    <?php
    $sourceId = $intertext->source_id;
    $sourceName = '';
    $authorName = '';
    $authorId = '';
    $informationAuthors = '';
    $informationText = '';
    if ($sourceId){
        $sourceName = \App\Models\Intertexts\IntertextSource::find($sourceId)->source_name;
        $authorName = \App\Models\Intertexts\SourceAuthor::find($intertext->source->author_id)->author_name;
        $validSource = $intertext->source->is_valid_source;
        $authorId = $intertext->source->author_id;
        $informationText = $intertext->source->source_information_text;
        $informationAuthors = \App\Models\Intertexts\IntertextSource::getInfoAuthorsImplode($intertext->source);
        if (!$validSource)
        {
            $informationText = $intertext->source->author->source_information_text;
            $informationAuthors = \App\Models\Intertexts\SourceAuthor::getInfoAuthorsImplode($intertext->source->author);
        }
    }

    ?>

    @if($sourceId)
    <h3>Source
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $sourceId) }}"
           title="Source anzeigen">
            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
        </a>
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'edit'], $sourceId) }}"
           title="Source bearbeiten">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'create']) }}"
           title="Neue Source hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Source</span>
            {!! $sourceName !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Author</span>
            {!! $authorName !!}
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'show'], $authorId) }}"
               title="Source author anzeigen">
                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
            </a>
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'edit'], $sourceId) }}"
               title="Source author bearbeiten">
                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
            </a>
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'create']) }}"
               title="Neue Source Author hinzufügen">
                <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
            </a>
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Chapter</span>
            {!! $intertext->source_chapter; !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Information Text Authors</span>
            {!! $informationAuthors !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Information Text</span>
            {!! $informationText !!}
        </li>
    </ul>
    @endif


    <h3>Original Reference Texts
        <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'create'], $intertext->id) }}"
           title="Neue Original Translation hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h3>

    <?php
    $languageId = $intertext->language_id;
    $originalLanguage = '';
    if ($languageId) {
        $originalLanguage = \App\Models\Intertexts\OriginalLanguage::find($languageId)->original_language;
    }
    ?>

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Original Language</span>
            {!! $originalLanguage !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Language Direction</span>
            {!! $intertext->language_direction !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Original Text</span>
            {!! $intertext->source_text_original !!}
        </li>
        <h5>Translations:</h5>

        @foreach($intertext->originalTranslations as $originalText)
            <?php $language = $originalText->language->translation_language?>
            <li class="list-group-item">
                <span class="label label-default">{{ ucfirst($language) }} Original Text</span>
                {!! $originalText->source_text_translation !!}
                <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'show'], $originalText->id) }}"
                   title="Entry anzeigen">
                    <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                </a>
                <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'edit'], $originalText->id) }}">
                    <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                </a>
            </li>
        @endforeach
    </ul>


    <h3>Transcriptions</h3>

    <?php
    $scriptId = $intertext->script_id;
    $script = '';
    if ($scriptId) {
        $script = \App\Models\Intertexts\Script::find($scriptId)->script;
    }
    ?>

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Script</span>
            {!! $script !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Transcription Text</span>
            {!! $intertext->source_text_transcription !!}
        </li>
    </ul>

    <h3>Keywords</h3>

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Keyword</span>
            {!! $intertext->keyword !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Keyword Persons</span>
            {!! $intertext->keyword_persons !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Keyword Places</span>
            {!! $intertext->keyword_places !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Keyword Others</span>
            {!! $intertext->keyword_others !!}
        </li>
    </ul>

    <h2>Bilder</h2>

    @foreach($intertext->images as $image)
        <div>
            <figure>
                <a href="{{ Config::get("constants.digilib.scaler") . $image->image_link . "&mo=ascale,1"}}">
                    <img src="{{ Config::get("constants.digilib.scaler") . $image->image_link . "&mo=ascale,1"}}" alt="">
                </a>
                <figcaption>{{ $image->licence_for_image }}</figcaption>
            </figure>
        </div>
    @endforeach



@endsection
