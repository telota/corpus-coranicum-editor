@extends("layouts.master")

@section("title")
    <h1>
        Scripts
        <a href="{{ URL::action([App\Http\Controllers\IntertextScriptController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"
            title="Script hinzufügen"></span>
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
        @foreach($scripts as $script)
            <tr>
                <td>{{ $script->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextScriptController::class, 'show'], $script->id) }}">
                        {{ $script->script }}
                    </a>

                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextScriptController::class, 'show'], $script->id) }}"
                           title="Script anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\IntertextScriptController::class, 'edit'], $script->id) }}"
                           title="Script bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                        </span>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
