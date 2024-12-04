@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ $options[$selected] }}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                {{ $label }}
            </div>
        </div>
        <div class="panel-body">
            @foreach($options as $key=>$display)
                <div class='input-group'>
                    <label for="{{$key}}">
                        <input
                                type="radio"
                                id="{{$key}}"
                                name="{{$name}}"
                                value="{{$key}}"
                                {{ $selected == $key ? "checked" : "" }}
                        />
                        {{$display}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif
