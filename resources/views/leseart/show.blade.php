@extends("layouts.master")

@section("title")

    <h1>
        Lesart {{$leseart->id}}

        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'edit'], $leseart->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>

@endsection


@section("content")

    <h2>Informationen</h2>

    @include("includes.metadata", array("record" => $leseart))

    <hr>


    <h2>Quelle & Leser</h2>

    <ul class="list-group">

        <li class="list-group-item">
            <span class="label label-default">Quelle {{ $leseart->quelle->id }}</span>

            <a href="{{ route('show', ["category"=>\App\Enums\Category::Quelle, "id" =>$leseart->quelle->id]) }}">
                {{ $leseart->quelle->anzeigetitel }}
            </a>

        </li>


        @foreach($leseart->leser as $i => $leser)

            <li class="list-group-item">
                <span class="label label-default">Leser {{ $i + 1 }}</span>
                <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $leser->id) }}">
                    {{ $leser->anzeigename ?? "Leser existiert nicht"}}
                </a>
            </li>

        @endforeach

    </ul>


    <hr>

    <h2>Varianten</h2>

    <ul class="list-group">

        @for($i = 1; $i <= App\Models\Sure::getMaxWort($leseart->sure, $leseart->vers); $i++)

            @if(!empty($leseart->variantenWort($i)->variante))

                <li class="list-group-item">
                    <span class="label label-default">{{ $leseart->variantenWort($i)->koranstelle->coordinate }}</span>


                    <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'wordIndex'], $leseart->variantenWort($i)->variante) }}">
                        {{ $leseart->variantenWort($i)->variante }}
                    </a>

                    <span class="text-muted arab arab-word">{{ $leseart->variantenWort($i)->koranstelle->arab }}</span>

                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'wordIndex'], $leseart->variantenWort($i)->variante) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                  title="Koranstellen zu diesem Wort anzeigen"></span>
                        </a>
                    </span>

                    @endif

                </li>

                @endfor

    </ul>



    <hr>

    <span class="pull-right">


            <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'destroy'], $leseart->id) }}"
               class="btn btn-danger delete-record">
                <span class="glyphicon glyphicon-remove"></span>
                Löschen
            </a>


        </span>

@endsection