@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ $entity->$dbField ?? "" }}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <label for="{{$entity->$dbField}}" class="panel-title">
                {{ $label }}
            </label>
        </div>
        <div class="panel-body">
            <div class="input-group">
                <input class="form-control" name="{{$dbField}}" id="{{$dbField}}" type="{{$inputType}}"
                       @if (isset($placeholder)) placeholder="{{$placeholder}}" @endif
                       value="{{old($dbField, $entity->$dbField)}}"
                >
            </div>
        </div>
    </div>
@endif

