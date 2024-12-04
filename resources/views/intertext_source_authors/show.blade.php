@extends("layouts.master")

@section("title")
    <h1>
        {{ $author->author_name  }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'edit'], $author->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    {{--    @include("includes.metadata", array("record" => $author))--}}

    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">ID</span>
            {!! $author->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Author Name</span>
            {!! $author->author_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $author->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $author->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $author->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $author->updated_at !!}
        </li>
    </ul>

    <h3>
        Information Text
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorInformationTranslationController::class, 'create'], $author->id) }}"
           title="Neue Entry Translation hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">Information Text Authors</span>
            {!! \App\Models\Intertexts\SourceAuthor::getInfoAuthorsImplode($author) !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Information Text</span>
            {!! $author->source_information_text !!}
        </li>
        <h5>Translations:</h5>
        @foreach($author->infoTranslations as $info)
            <?php $language = $info->language->translation_language?>
            <li class="list-group-item">
                <span class="label label-default">{{ ucfirst($language) }} Information Text</span>
                {!! $info->information_translation !!}
                <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorInformationTranslationController::class, 'show'], $info->id) }}"
                   title="Entry anzeigen">
                    <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                </a>
                <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorInformationTranslationController::class, 'edit'], $info->id) }}">
                    <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                </a>
            </li>
        @endforeach
    </ul>

    <h2>Sources
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'create']) }}"
           title="Neues Source hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h2>
    <hr>
    <?php $onlineString = array(2 => "ja", 1 => "Webtauglich (ohne Bild)", 0 => "nein");
    ?>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        </thead>

        <tbody>
        @foreach($author->sources as $source)
            <tr>
                <td>
                    {{ $source->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $source->id) }}">
                        {{ strip_tags($source->source_name) }}
                    </a>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $source->id) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                  title="Manuskriptseite anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'edit'], $source->id) }}">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"
                                  title="Manuskriptseite bearbeiten"></span>
                        </a>
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection
