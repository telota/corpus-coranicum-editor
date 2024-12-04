@extends("layouts.master")

@section("title")

    <h1>
        Lesarten für: <em>
            {{ $word }}
        </em>

    </h1>

@endsection

@section("content")

<table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

    <thead>
    <tr>
        <th>Sure</th>
        <th>Vers</th>
        <th>Quelle</th>
        <th>Leser</th>
    </tr>
    </thead>
    <tbody>

        @foreach($variants as $variant)

            <tr>

                <td>

                    <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $variant->vleseart->id) }}">
                        {{ $variant->vleseart->sure }}
                    </a>

                </td>

                <td>
                    <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $variant->vleseart->id) }}">
                        {{ $variant->vleseart->vers }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('show', ["category"=>'quelle' ,"id"=>$variant->vleseart->quelle->id]) }}">
                        {{ $variant->vleseart->quelle->anzeigetitel }}
                    </a>

                </td>

                <td>
                    <ul>
                    @foreach($variant->vleseart->leser as $leser)
                        <li>
                            <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $leser->id) }}">
                                {{ $leser->anzeigename }}
                            </a>
                        </li>
                    @endforeach
                    </ul>

                    <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $variant->vleseart->id) }}">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                            title="Leseart anzeigen"></span>
                        </a>

                        <a href="{{ route('show', ["category"=>'quelle' ,"id"=>$variant->vleseart->quelle->id]) }}">
                             <span class="glyphicon glyphicon-book glyphicon-hover"
                             title="Quelle anzeigen"></span>
                         </a>

                    </span>

                </td>

            </tr>

        @endforeach

    </tbody>


</table>

@endsection