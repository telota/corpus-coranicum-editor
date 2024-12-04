@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ Carbon\Carbon::parse($datetime)->format('Y-m-d H:i') }}
        </td>
    </tr>

@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">{{ $label }}</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group">
                        <label
                                class='input-group-addon'
                                for='{{$dbField . "_day"}}'
                        >Day</label>
                        <input
                                class='form-control'
                                type='date'
                                name='{{$dbField . "_day"}}'
                                id='{{$dbField . "_day"}}'
                                value='{{old($dbField . "_day", $day)}}'

                        >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <label
                                class='input-group-addon'
                                for='{{$dbField . "_time"}}'
                        >Time</label>
                        <input
                                class='form-control'
                                type='time'
                                name='{{$dbField . "_time"}}'
                                id='{{$dbField . "_time"}}'
                                value='{{old($dbField . "_time", $time)}}'
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif