@extends("layouts.master")

@section("title")
    <h1>
       Sources
        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'create']) }}">
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
        @foreach($sources as $source)
            <tr>
                <td>{{ $source->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $source->id) }}">
                        {{ $source->source_name }}
                    </a>

                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $source->id) }}"
                           title="Assistance anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'edit'], $source->id) }}"
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
