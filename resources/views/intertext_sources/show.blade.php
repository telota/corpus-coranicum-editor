@extends("layouts.master")

@section("title")
    <h1>
        {{ $source->source_name  }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'edit'], $source->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

{{--    @include("includes.metadata", array("record" => $source))--}}
<h3>Metadata</h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">ID</span>
            {!! $source->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Source Name</span>
            {!! $source->source_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Author</span>
            {!! $source->getAuthorName() !!}
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'show'], $source->author->id) }}"
               title="Author anzeigen">
                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
            </a>
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'edit'], $source->author->id) }}">
                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
            </a>
        </li>
        <li class="list-group-item">
            <span class="label label-default">Valid Source</span>
            {!! $source->is_valid_source !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $source->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $source->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $source->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $source->updated_at !!}
        </li>
    </ul>

<h3>
    Information Text
    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceInformationTranslationController::class, 'create'], $source->id) }}"
       title="Neue Information Text Translation hinzufügen">
        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
    </a>
</h3>
<ul class="list-group">
    <li class="list-group-item">
        <span class="label label-default">Information Text Authors</span>
        {!! \App\Models\Intertexts\IntertextSource::getInfoAuthorsImplode($source) !!}
    </li>
    <li class="list-group-item">
        <span class="label label-default">Information Text</span>
        {!! $source->source_information_text !!}
    </li>
    <h5>Translations:</h5>
    @foreach($source->infoTranslations as $info)
        <?php $language = $info->language->translation_language?>
        <li class="list-group-item">
            <span class="label label-default">{{ ucfirst($language) }} Info</span>
            {!! $info->information_translation !!}
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceInformationTranslationController::class, 'show'], $info->id) }}"
               title="Translation anzeigen">
                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
            </a>
            <a href="{{ URL::action([App\Http\Controllers\IntertextSourceInformationTranslationController::class, 'edit'], $info->id) }}">
                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
            </a>
        </li>
    @endforeach
</ul>


    <h2>Intertexts</h2>
    <hr>
    <?php $onlineString = array(2 => "ja", 1 => "Webtauglich (ohne Bild)", 0 => "nein");
    ?>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>webtauglich</th>
        </tr>
        </thead>

        <tbody>
            @foreach($source->intertexts as $intertext)
            <tr>
                <td>
                    {{ $intertext->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
                        {{ strip_tags($intertext->getNameString()) }}
                    </a>
                </td>
                <td>{{ $onlineString[$intertext->is_online] }}
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                  title="Manuskriptseite anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'edit'], $intertext->id) }}">
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
