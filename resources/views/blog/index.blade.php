@extends("layouts.master")

@section("title")

    <h1>
        Blogeinträge
        <a href="{{ URL::action([App\Http\Controllers\BlogController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h1>

@endsection

@section("content")

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Erstellt</th>
            </tr>
        </thead>
        <tbody>

            @foreach($blogs as $blog)

                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\BlogController::class, 'show'], $blog->id) }}">
                            {{ $blog->title }}
                        </a>
                    </td>
                    <td>
                        {{ $blog->created_at }}
                        <span class="pull-right">

                            <a href="{{ URL::action([App\Http\Controllers\BlogController::class, 'show'], $blog->id) }}"
                               title="Blogeintrag anzeigen">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                            </a>
                            <a href="{{ URL::action([App\Http\Controllers\BlogController::class, 'edit'], $blog->id) }}"
                            title="Blogeintrag bearbeiten">
                                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                            </a>

                    </span>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endsection