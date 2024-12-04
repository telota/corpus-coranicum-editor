@extends("layouts.master")

@section("title")

    <h1>
        Leser
        <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h1>

@endsection

@section("content")

    <table class="dataTable table table-striped" id="leser-table" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Sigle</th>
        </tr>
        </thead>
        <tbody>

            @foreach($leser as $l)

                <tr>
                    <td>{{ $l->id }}</td>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $l->id) }}">
                            {{ $l->name }}
                        </a>

                    </td>
                    <td>{{ $l->sigle }}

                        <span class="pull-right">

                            @if(count($l->mappings) == 0)

                                <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $l->id) }}" title="Leser löschen (in Detailanzeige)">
                                    <span class="glyphicon glyphicon-remove glyphicon-hover"></span>
                                </a>

                            @endif

                            <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $l->id) }}" title="Leser anzeigen ">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                            </a>
                        </span>

                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endsection