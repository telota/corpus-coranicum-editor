@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->provenances->pluck('id');
    $options = \App\Models\Manuscripts\Provenance::all()->mapWithKeys(fn($item)=>[$item->id => $item->provenance]);
@endphp
<x-form.checkboxes :$action label='Provenances' name='provenances' :$values :$options />