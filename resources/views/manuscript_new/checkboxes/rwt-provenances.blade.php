@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->rwtProvenances->pluck('id');
    $options = \App\Models\Manuscripts\Provenance::all()->mapWithKeys(fn($item)=>[$item->id => $item->provenance]);
@endphp
<x-form.checkboxes :$action label='Regional Writing Tradition Provenances' name='rwt_provenances' :$values :$options />
