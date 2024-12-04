@extends("layouts.master")

@section("title")

    <h1>
        {{ $leser->anzeigename }}
        <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'edit'], $leser->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>

        @if($leser->mappings()->count() == 0)

            <span class="pull-right">

            <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'destroy'], $leser->id) }}" class="btn btn-danger delete-record">
                <span class="glyphicon glyphicon-remove"></span>
                Löschen
            </a>


            </span>

        @endif

    </h1>



@endsection

@section("content")

    @include("includes.metadata", array("record" => $leser))

    <hr>

    @if(count($leser->aliases) > 0)

        <h2>Aliase vom Leser</h2>

        <ul class="list-group">

            @foreach($leser->aliases as $index => $alias)
            <li class="list-group-item">
                <span class="label label-default">{{ $index + 1 }}</span>  {{ $alias->alias }}
            </li>
            @endforeach

        </ul>

        <hr>

    @endif

    <h2>
        Lesarten vom Leser
        <a href="{{ URL::route("lesearten.leser.create", $leser->id) }}"
        title="Neue Lesart zum Leser anlegen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h2>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>ID</th>
            <th>Quelle</th>
            <th>Koranstelle</th>
            <th>Kanonisch</th>
        </tr>
        </thead>
        <tbody>

        @foreach($leser->mappings as $mapping)

            @foreach($mapping->lesearten as $leseart)

                <tr>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $leseart->id) }}"
                        title="Leseart anzeigen">
                            {{ $leseart->id }}
                        </a>

                    </td>
                    <td>
                        <a href="{{ route('show', ["category" => \App\Enums\Category::Quelle, "id" => $leseart->quelle->id]) }}"
                        title="Quelle anzeigen">
                            {{ $leseart->quelle->anzeigetitel }}
                        </a>

                    </td>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $leseart->id) }}"
                        title="Leseart anzeigen">
                            {{ str_pad($leseart->sure, 3, 0, STR_PAD_LEFT) }}:
                            {{ str_pad($leseart->vers, 3, 0, STR_PAD_LEFT) }}
                        </a>
                    </td>
                    <td>{{ ($leseart->kanonisch) ? "kanonisch" : "nicht kanonisch"}}
                        <span class="pull-right">
                            <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $leseart->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Leseart anzeigen"></span>
                            </a>
                            <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'edit'], $leseart->id) }}">
                                <span class="glyphicon glyphicon-pencil glyphicon-hover"
                                      title="Leseart bearbeiten"></span>
                            </a>
                        <a href="{{ route('show', ["category" => \App\Enums\Category::Quelle, "id" => $leseart->quelle->id]) }}">
                                <span class="glyphicon glyphicon-book glyphicon-hover"
                                title="Quelle Anzeigen"></span>
                            </a>
                            <a href="{{ URL::route("lesearten.quellen.leser.create", array($leseart->quelle->id, $leser->id)) }}">
                                <span class="glyphicon glyphicon-plus glyphicon-hover"
                                title="Neue Leseart mit dieser Quelle und diesem Leser anlegen"></span>
                            </a>
                        </span>
                    </td>
                </tr>

            @endforeach

        @endforeach

        </tbody>



@endsection