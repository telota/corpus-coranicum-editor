@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->provenances->pluck('id');
    $options = \App\Models\Manuscripts\Diacritic::all()->mapWithKeys(fn($item)=>[$item->id => $item->diacritic]);
@endphp
<x-form.checkboxes :$action label='Diacritics' name='diacritics' :$values :$options>
    <div class="space-between" style='margin: 10px 30px '>
        <button type="button" class="btn btn-info" id="diacritic_classical_arabic">Classical Arabic</button>
        <button type="button" class="btn btn-info" id="diacritic_maghrebi">Maghrebi</button>
        <button type="button" class="btn btn-info" id="diacritic_ancient">Ancient</button>
        <button type="button" class="btn btn-info" id="diacritic_clear">Clear All</button>
    </div>
    <hr>
</x-form.checkboxes>
