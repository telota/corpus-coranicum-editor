@extends("layouts.master")

@section("title")
Handschriften - Übersicht

@endsection

@section("content")


    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kodextitel</th>
                <th>Aufbewahrungsort</th>
                <th>Webtauglich</th>
            </tr>
        </thead>

        <tbody>
        @foreach($manuskripte as $manuskript)

            <tr>
                <td>{{ $manuskript->ID }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\ManuskriptController::class, 'show'], $manuskript->ID) }}">
                        {{ strip_tags($manuskript->Kodextitel) }}
                    </a>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\ManuskriptController::class, 'show'], $manuskript->ID) }}"
                                title="Manuskript anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>
                    </span>
                </td>
                <td>
                    <a href="{{ route('show', ['category'=>\App\Enums\Category::Place, 'id'=>$manuskript->place_id ?? 0]) }}">
                     {{ strip_tags($manuskript->Aufbewahrungsort) }}
                    </a>
                </td>
                <td>{{ strip_tags($manuskript->webtauglich) }}</td>
            </tr>

        @endforeach
        </tbody>

    </table>

@endsection