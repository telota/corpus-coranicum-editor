@php
    $author_values = $entity->authors->filter(fn($a)=> $a->role->role_name == $role)->pluck('id');
    $author_names = $entity->authors->filter(fn($a)=> $a->role->role_name == $role)->pluck('author.author_name')->implode('; ');

    $author_options = \App\Models\GeneralCC\CCAuthorRole::all()
    ->filter(fn ($a) => $a->role->role_name == $role && $a->role->module->module_name == $module )
    ->mapWithKeys(fn($entry) => [$entry->id => $entry->author->author_name]);
@endphp
<x-form.checkboxes :label='ucfirst($role)' name='authors'
                   :values='$author_values' :options='$author_options'
                   :$action
                   :displayText='$author_names'
/>
