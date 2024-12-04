<table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

    <thead>
    <tr>
        <th>ID</th>
        <th>Quelle</th>
        <th>Leser</th>
        <th>Textstelle</th>
    </tr>
    </thead>
    <tbody>

    @foreach($lesearten as $leseart)

        <tr>
            <td>
                <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $leseart->id) }}"
                   title="Leseart anzeigen">
                    {{ $leseart->id }}
                </a>

            </td>
            <td>
                <a href="{{ route('show', ['id'=>$leseart->quelle->id, 'category'=>\App\Enums\Category::Quelle]) }}"
                   title="Quelle anzeigen">
                    {{ $leseart->quelle->anzeigetitel }}
                </a>
            </td>
            <td>

                <ul>
                    @foreach($leseart->leser as $leser)

                        <li>
                            <a href="{{ URL::action([App\Http\Controllers\LeserController::class, 'show'], $leser["id"]) }}"
                               title="Leser anzeigen">
                                {{ $leser["anzeigename"] }}
                            </a>
                        </li>

                    @endforeach
                </ul>
            </td>
            <td>
                <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'koranstellenShow'], array($leseart->sure, $leseart->vers)) }}"
                   title="Leseart anzeigen">
                    {{ str_pad($leseart->sure, 3, 0, STR_PAD_LEFT) }}:
                    {{ str_pad($leseart->vers, 3, 0, STR_PAD_LEFT) }}
                </a>
                <span class="pull-right ">

                    <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'show'], $leseart->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Leseart anzeigen"></span>
                    </a>

                    <a href="{{ URL::action([App\Http\Controllers\LeseartenController::class, 'edit'], $leseart->id) }}">
                        <span class="glyphicon glyphicon-pencil glyphicon-hover"
                              title="Leseart bearbeiten"></span>
                    </a>

                <a href="{{ route('show', ['id'=>$leseart->quelle->id, 'category'=>\App\Enums\Category::Quelle]) }}">
                                <span class="glyphicon glyphicon-book glyphicon-hover"
                                      title="Quelle Anzeigen"></span>
                    </a>

                </span>


            </td>


        </tr>

    @endforeach

    </tbody>

</table>