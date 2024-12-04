@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {!! $entity->$dbField ?? "" !!}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title" style='display: inline; margin-right: 5px'>{{ $label }}</div>
        <button type="button" class='btn btn-primary btn-sm summernote-activator' summernote-target="#{{ $dbField }}">
            Edit in Editor
            <span class="glyphicon glyphicon-pencil"></span>
        </button>
        <button type="button"
                style='display: none'
                class='btn btn-primary btn-sm summernote-deactivator' summernote-target="#{{ $dbField }}">
            Show Raw Html
            <span class="glyphicon glyphicon-pencil"></span>
        </button>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <textarea name='{{$dbField}}' id='{{$dbField}}' style='width: 100%; min-height: 200px'>
            {{old($dbField, $entity->$dbField)}}
            </textarea>
        </div>
    </div>
</div>

    @include('components.summernote.zotero')
    @include('components.summernote.intertexts')
@endif