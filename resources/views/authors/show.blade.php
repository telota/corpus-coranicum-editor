@extends("layouts.master")

@section("title")
    <h1>
        {{ $author->author  }}
        <a href="{{ URL::action([App\Http\Controllers\AuthorController::class, 'edit'], $author->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $author))

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
            @foreach($author->manuscripts as $manuscriptAuthor)
                <?php $manuscript = App\Models\Manuskripte\ManuscriptNew::find($manuscriptAuthor->manuscript_id)?>
            <tr>
                <td>
                    {{ $manuscript->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $manuscript->id) }}">
                        {{ strip_tags($manuscript->getNameString()) }}
                    </a>
                </td>
                <td>{{ $onlineString[$manuscript->online] }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

@endsection
