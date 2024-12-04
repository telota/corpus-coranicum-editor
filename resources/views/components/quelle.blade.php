@php
    $editor_values = $entity->authors->pluck('id');

    $editor_options = \App\Models\GeneralCC\CCAuthorRole::all()
    ->filter(fn ($entry) => $entry->role->role_name == 'editor' && $entry->role->module->module_name == 'variants' )
    ->mapWithKeys(fn($entry) => [$entry->id => $entry->author->author_name]);
@endphp
<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false' />
<x-form.text :$entity dbField='abkuerzung' label='Sigle (Abkuerzung)' :$action />
<x-form.radio-buttons name='kanonisch' label='Kanonisch'
                      :options='collect([0=>"Nein", 1=>"Ja"])'
                      :selected='$entity->kanonisch > 0 ? 1 : 0' :$action />
<x-form.text :$entity dbField='quelle_arabisch' label='Quelle Arabisch' :$action />
<x-form.text :$entity dbField='autor_arabisch' label='Autor Arabisch' :$action />
<x-form.text :$entity dbField='anzeigetitel' label='Anzeigetitel' :$action />
<x-form.text :$entity dbField='autor_langfassung' label='Autor Langfassung' :$action />
<x-form.text :$entity dbField='todesdatum' label='Todesdatum' :$action />
<x-form.text :$entity dbField='todesdatum_ah' label='Todesdatum Ah' :$action />
<x-form.text :$entity dbField='ort' label='Ort' :$action />
<x-form.text :$entity dbField='referenz' label='Referenz' :$action />
<x-form.text :$entity dbField='sort' label='Sort' :$action />
@foreach(['editor','collaborator','earlier_contributor'] as $role)
    <x-form.authors :$entity :$role module='variants' :$action />
@endforeach
<x-history :$entity :$action />