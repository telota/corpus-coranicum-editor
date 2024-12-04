@extends("layouts.master")

@section("title")

    <h1>
        Lesarten für Sure {{ $sure }}
        <span class="pull-right">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="surenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Sure auwählen
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="surenauswahl">
                    @for($i = 1; $i <= 114; $i++)

                        <li {{ ($i == $sure) ? 'class=active' : "" }}>
                            <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'koranstellenIndex'], $i) }}">{{ $i }}</a></li>

                    @endfor
                </ul>
            </div>
        </span>
    </h1>

@endsection


@section("content")


    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>Sure</th>
            <th>Vers</th>
            <th>Koranstelle</th>
            <th>Anzahl Lesarten</th>
            <th>Kommentar</th>
        </tr>
        </thead>
        <tbody>

        @for($i = 1; $i <= $maxVers; $i++)

            <?php $numReadings = App\Models\Lesarten\Leseart::where("sure", "=", $sure)
                            ->where("vers", "=", $i)->count();

                $kommentar = App\Models\Koran::getLeseartenKommentar($sure, $i, true);
            ?>

            <tr>
                <td>{{ $sure }}</td>
                <td>{{ $i}}</td>
                <td>

                    @if($numReadings > 0)

                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'koranstellenShow'], array($sure, $i)) }}">
                            {{ str_pad($sure, 3, 0, STR_PAD_LEFT) }}:
                            {{ str_pad($i   , 3, 0, STR_PAD_LEFT) }}
                        </a>

                    @else

                        {{ str_pad($sure, 3, 0, STR_PAD_LEFT) }}:
                        {{ str_pad($i   , 3, 0, STR_PAD_LEFT) }}

                    @endif

                </td>
                <td>
                    {{ $numReadings }}
                </td>



                <td>

                    <a href="{{ URL::route("showLeseartKommentar", [$sure, $i]) }}">
                        {{ ($kommentar) ? "vorhanden" : "nicht vorhanden" }}
                    </a>


                    <span class="pull-right">
                        
                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'koranstellenShow'], [$sure, $i]) }}"
                        title="Lesearten zur Koranstelle anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>
                        
                        <a href="{{ URL::route("lesearten.koranstellen.create", [$sure, $i]) }}"
                        title="Neue Leseart zur Koranstelle anlegen">
                            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::route("showLeseartKommentar", [$sure, $i]) }}">
                            <span class="glyphicon glyphicon-book glyphicon-hover"
                            title="Kommentar anzeigen"></span>
                        </a>
                        
                    </span>

                </td>

            </tr>

            @endfor

        </tbody>

    </table>

    <hr>




@endsection