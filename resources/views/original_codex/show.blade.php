@extends("layouts.master")

@section("title")
    <h1>
        {{ $originalCodex->original_codex_name  }}
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptOriginalCodexController::class, 'edit'], $originalCodex->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $originalCodex))

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
            @foreach($originalCodex->manuscripts as $manuscript)
            <tr>
                <td>
                    {{ $manuscript->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">
                    {{ strip_tags($manuscript->getNameString()) }}
                    </a>
                </td>
                <td>{{ $onlineString[$manuscript->is_online] }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

@endsection
