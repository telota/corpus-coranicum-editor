@php
    $displayText = "";
    if($options->has($value)){
        $displayText = $options[$value];
        if($options[$value] != $value){
            $displayText . "($value)";
        }
    }

@endphp
@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{$displayText}}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <x-form.select-input :$label :$name :$options :value='old($name, $value)' />
@endif