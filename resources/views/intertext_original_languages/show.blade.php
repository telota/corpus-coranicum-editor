@extends("layouts.master")

@section("title")
    <h1>
        {{ $language->original_language  }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalLanguageController::class, 'edit'], $language->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $language))
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
            @foreach($language->intertexts as $intertext)
            <tr>
                <td>
                    {{ $intertext->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
                        {{ strip_tags($intertext->getNameString()) }}
                    </a>
                </td>
                <td>{{ $onlineString[$intertext->is_online] }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

@endsection
