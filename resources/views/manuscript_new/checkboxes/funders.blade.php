@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->funders->pluck('id');
    $options = \App\Models\Manuscripts\Funder::all()->mapWithKeys(fn($item)=>[$item->id => $item->funder]);
@endphp
<x-form.checkboxes :$action label='Funders' name='funders' :$values :$options />
