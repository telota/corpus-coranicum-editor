@extends("layouts.master")

@section("title")

    <h1>Umwelttexte Neu

        {{ (isset($sure)) ? " für Sure " . $sure : "" }}{{ (isset($vers)) ? ", Vers " . $vers : "" }}


        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>


    </h1>


        <div class="btn-group">
            <div class="dropdown btn-group">
                <button class="btn btn-default dropdown-toggle pull" type="button" id="surenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Sure {{ (isset($sure) ? $sure : "auswählen") }}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu scrollable" aria-labelledby="surenauswahl">
                    @for($i = 1; $i <= 114; $i++)

                        @if(isset($sure))
                            <li {{ ($i == $sure) ? 'class=active' : "" }}>
                                <a href="{{ URL::route("intertexts.index.sure", $i) }}">{{ $i }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ URL::route("intertexts.index.sure", $i) }}">{{ $i }}</a>
                            </li>
                        @endif

                    @endfor
                </ul>
            </div>

            @if(isset($sure))

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="versauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Vers {{ (isset($vers)) ? $vers : " auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="versauswahl">
                        @for($i = 1; $i <= $maxVers; $i++)

                            @if(isset($vers))
                                <li {{ ($i == $vers) ? 'class=active' : "" }}>
                                    <a href="{{ URL::route("intertexts.index.vers", array($sure, $i)) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ URL::route("intertexts.index.vers", array($sure, $i)) }}">{{ $i }}</a>
                                </li>
                            @endif

                        @endfor
                    </ul>

                </div>

            @endif

            <div class="dropdown btn-group">

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="sprachauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-flag"></span>
                        {{ (isset($lang)) ? \App\Models\Intertexts\OriginalLanguage::find($lang)->original_language : "Sprache auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="sprachauswahl">

                        @foreach(\App\Models\Intertexts\OriginalLanguage::all() as $language)

                            @if(isset($lang))
                                <li {{ ($lang == $language->id) ? 'class=active' : "" }}>
                                    <a href="{{ URL::route("intertexts.index.language", urlencode($language->id)) }}">{{ $language->original_language }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ URL::route("intertexts.index.language", urlencode($language->id)) }}">{{ $language->original_language }}</a>
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>
            <div class="dropdown btn-group">

                <div class="dropdown btn-group">

                    <button class="btn btn-default dropdown-toggle" type="button" id="sprachauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{ (isset($categoryId)) ? $categoryId . ' : ' . \App\Models\Intertexts\IntertextCategory::find($categoryId)->category_name : "Kategorie auswählen" }}
                        <span class="caret"></span>
                    </button>

                    <ul class="dropdown-menu scrollable" aria-labelledby="versauswahl">

                        @foreach(\App\Models\Intertexts\IntertextCategory::all() as $kate)

                            @if(strlen($kate->id) < 2)
                                <h4 class="dropdown-header"><u><a href="{{ URL::route("intertexts.index.category", $kate->id) }}">{{ $kate->id }} : {{ $kate->category_name }}</a></u></h4>
                            @else
                                    <li class='dropdown-item' . {{ isset($categoryId) ? (($categoryId == $kate->id) ? ' active' : "" ) : "" }}>
                                        <a href="{{ URL::route("intertexts.index.category", $kate->id) }}">{{ $kate->id }} : {{ $kate->category_name }}</a>
                                    </li>
                            @endif
                        @endforeach

                    </ul>

                </div>
            </div>
        </div>


@endsection



@section("content")

    <table id="umwelttexte-table" class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Autor</th>
            <th>Sprache</th>

            @if(isset($sure) && (!(isset($vers))))

                <th>Textstellen</th>

            @endif

            <th>Chron.</th>
            {{--<th>Kategorie</th>--}}
            <th>Webtauglich</th>
            <th>Bearbeiter</th>
        </tr>
        </thead>
        <tbody>

        @foreach($intertexts as $intertext)

            <?php
            $sourceId = $intertext->source_id;
            $authorName = '';
            if ($sourceId){
                $authorName = \App\Models\Intertexts\SourceAuthor::find($intertext->source->author_id)->author_name;
            }

            $languageId = $intertext->language_id;
            $originalLanguage = '';
            if ($languageId) {
                $originalLanguage = \App\Models\Intertexts\OriginalLanguage::find($languageId)->original_language;
            }

            ?>

            <tr>
                <td>{{ $intertext->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
                        {{ $intertext->getNameString() }}
                    </a>
                </td>
                <td>{{ $authorName }}</td>
                <td>{{ $originalLanguage }}</td>

                @if(isset($sure) && (!(isset($vers))))

                    <td class="no-bullets">
                        <ul>
                            @foreach($quranTexts[$intertext->id] as $stelle)
                            <li>{{ $stelle }}</li>
                            @endforeach
                        </ul>
                    </td>

                @endif

                <td>
                    {{ $intertext->chronology()["I"] }}-{{ $intertext->chronology()["II"] }}-{{ $intertext->chronology()["III"] }}-{{ $intertext->chronology()["IV"] }}
                </td>

                {{--<td>--}}
                    {{--{{ $intertext->kategorie }} {{ \App\Models\Umwelttexte\BelegstellenKategorie::find($intertext->kategorie) != null ? ' : ' . urldecode(\App\Models\Umwelttexte\BelegstellenKategorie::find($intertext->kategorie)->name) : '  ' }}--}}
                {{--</td>--}}
                <?php $onlineString = array(2 => "ja", 1 => "Webtauglich (ohne Bild)", 0 => "nein");
                ?>
                <td>{!! $onlineString[$intertext->is_online] !!}</td>

                <td>
                    {{ (empty($intertext->getAuthors())) ? $intertext->last_author :  implode(", ", $intertext->getAuthors()) }}
                <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}"
                           title="Umwelttext anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'edit'], $intertext->id) }}"
                           title="Umwelttext bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>

                    </span>
                </td>
            </tr>


        @endforeach

        </tbody>

    </table>

@endsection
