@extends("layouts.master")

@section("title")
    <h1>Koranstellen (Sure {{ $sure }})

    @include("includes.koran.sura-list")
    </h1>
@endsection

@section("content")

    <table id="paret-table" class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>Sure</th>
            <th>Vers</th>
            <th>Wort</th>
            <th>Transkription</th>
            <th>Arabisch</th>
            <th></th>
        </tr>
        </thead>

        <tbody>

            @foreach($words as $word)

                <tr>
                    <td>{{ $word->sure }}</td>
                    <td>{{ $word->vers }}</td>
                    <td>{{ $word->wort }}</td>
                    <td>{{ $word->transkription }}</td>
                    <td dir="rtl" class="arab">{{ $word->arab }}</td>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\KoranController::class, 'edit'], [$word->sure, $word->vers, $word->wort]) }}" class="pull-right">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endsection