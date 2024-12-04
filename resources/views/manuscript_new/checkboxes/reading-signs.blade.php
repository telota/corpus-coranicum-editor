@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->readingSigns->pluck('id');
    $options = \App\Models\Manuscripts\ReadingSign::all()->mapWithKeys(fn($item)=>[$item->id => $item->reading_sign]);
@endphp
<x-form.checkboxes :$action label='Reading Signs' name='reading_signs' :$values :$options />