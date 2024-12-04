@extends("layouts.master")

@section("title")
    <h1>
        Authors
        <a href="{{ URL::action([App\Http\Controllers\AuthorController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"
            title="Assistance hinzufügen"></span>
        </a>
    </h1>
@endsection

@section("content")

<table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
        @foreach($authors as $author)
            <tr>
                <td>{{ $author->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\AuthorController::class, 'show'], $author->id) }}">
                        {{ $author->author }}
                    </a>

                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\AuthorController::class, 'show'], $author->id) }}"
                           title="Assistance anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\AuthorController::class, 'edit'], $author->id) }}"
                           title="Assistance bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                        </span>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
