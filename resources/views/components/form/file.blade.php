@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ $path }}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <label for="{{$name}}" class="panel-title">
                {{ $label }}
            </label>
        </div>
        <div class="panel-body">
            <div class="input-group">
                <input class="form-control" name="{{$name}}" id="{{$name}}" type="file"
                       accept='image/*'
                       @if (isset($placeholder)) placeholder="{{$placeholder}}" @endif
                >
            </div>
        </div>
    </div>
@endif