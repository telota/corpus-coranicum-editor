@php
    $action = \App\Enums\FormAction::Edit;
    $values = $record->verseSegmentations->pluck('id');
    $options = \App\Models\Manuscripts\VerseSegmentation::all()->mapWithKeys(fn($item)=>[$item->id => $item->name]);
@endphp
<x-form.checkboxes :$action label='Verse Segmentation' name='verse_segmentations' :$values :$options />
