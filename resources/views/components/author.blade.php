@php
    $options = \App\Models\GeneralCC\CCRole::with('module')
    ->whereHas('module', fn($q)=>$q->where('module_name','manuscript')->orWhere('module_name','variants'))
    ->get()
    ->mapWithKeys(fn($r)=>[ App\Models\GeneralCC\CCRole::roleKey($r) => \App\Models\GeneralCC\CCRole::roleLabel($r)])
    ->sortKeys();
    $values = $entity->roles->map(fn($r)=>App\Models\GeneralCC\CCRole::roleKey($r));
    $displayText = $entity->roles->map(fn($r)=> ucfirst($r->module->module_name) . " " . $r->role_name)->implode('; ');

@endphp
<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false' />
<x-form.text :$entity dbField='author_name' label='Name' :$action />
<x-form.checkboxes :$entity label='Roles' name='roles'
                   :$displayText
                   :values='$values' :options='$options' :$action />
<x-history :$entity :$action />