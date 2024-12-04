@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            <x-dynamic-component :component='$showComponent' :entity='$entities->firstWhere("id", $value)' />
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <x-form.select :$label :$action :$options :value='old($dbField, $value)' :name='$dbField' />
@endif
