@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ $displayText }}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                {{ $label }}
            </div>
        </div>
        {{$slot}}
        <div style='padding: 10px 0px; display: grid; grid-template-columns: repeat(3, 1fr); flex-wrap: wrap'>
            @foreach($options as $key=>$display)
                <div class='input-group' style='width: fit-content !important;'>
                    <label for="{{$name . "_" . $key}}" style='margin: 0px !important'>
                        <input
                                type="checkbox"
                                id="{{$name . "_" . $key}}"
                                name="{{$name}}[]"
                                value="{{$key}}"
                                {{ $values->contains($key) ? "checked" : "" }}
                                {{$action == \App\Enums\FormAction::Show ? "disabled" : ""}}
                        />
                        {{$display}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif