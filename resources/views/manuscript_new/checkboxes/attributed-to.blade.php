@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->attributedTo->pluck('id');
    $options = \App\Models\Manuscripts\Attribution::all()->mapWithKeys(fn($item)=>[$item->id => $item->person]);
@endphp
<x-form.checkboxes :$action label='Attributed To' name='attributed_to' :$values :$options />