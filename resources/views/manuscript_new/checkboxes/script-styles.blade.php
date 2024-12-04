@php
$action = \App\Enums\FormAction::Edit;
$values = $record->scriptStyles->pluck('id');
$options = \App\Models\Manuscripts\ScriptStyle::all()->mapWithKeys(fn($item)=>[$item->id => $item->style]);
@endphp
<x-form.checkboxes :$action label='Script Styles' name='script_styles' :$values :$options />