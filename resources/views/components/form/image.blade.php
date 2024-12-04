@if($action->value == 'show' && $show)
    @if($url != null || $entity->$dbField != null)
        <tr>
            <td class="labelColumn">
                {{ $label }}
            </td>
            <td>
                <x-image-display :url='$dbField ? $entity->$dbField : $url' />
            </td>
        </tr>
    @endif
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <label for="{{$entity->$dbField}}" class="panel-title">
                {{ $label }}
            </label>
        </div>
        <div class="panel-body">
            <div class="input-group">
                @if($url || $entity->$dbField)
                    <x-image-display :url='$dbField ? $entity->$dbField : $url' />
                @endif
                <input class="form-control" name="{{$dbField}}" id="{{$dbField}}" type="text"
                       @if (isset($placeholder)) placeholder="{{$placeholder}}" @endif
                       value="{{old($dbField, $entity->$dbField)}}"
                >
            </div>
        </div>
    </div>
@endif