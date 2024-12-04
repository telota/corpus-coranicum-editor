<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false' />
@php
$glossar = \App\Models\Glossareintrag::all();
$options = $glossar->mapWithKeys(fn($g)=>[$g->id=>$g->wort])
@endphp
<x-form.select-relational label='Glossareintrag' dbField='glossarium_id'
                          :entities='$glossar'
                          :$options
                          :value='$entity->glossarium_id'
                          optionLabel='wort'
                          showComponent='glossar-relational'
                          :$action />
<x-form.text :$entity label="Typ" dbField='typ' :$action />
<x-form.text :$entity label="Belegstelle" dbField='belegstelle' :$action />
<x-form.text :$entity label="Bearbeiter" dbField='bearbeiter' :$action />
<x-form.text :$entity label="Ort" dbField='ort' :$action />
<x-form.text :$entity label="Datierung" dbField='datierung' :$action />
<x-form.text :$entity label="Übersetzungsnachweis" dbField='uebersetzung_nachweis' :$action />
<x-form.wysiwyg :$entity dbField='originaltext' label='Originaltext' :$action />
<x-form.wysiwyg :$entity dbField='umschrift' label='Umschrift' :$action />
<x-form.text :$entity label="Bildlink" dbField='bildlink' :$action />
<x-form.text :$entity label="Edition" dbField='edition' :$action />
<x-form.wysiwyg :$entity dbField='uebersetzung' label='Übersetzung' :$action />
<x-form.wysiwyg :$entity dbField='anmerkung' label='Anmerkung' :$action />
<x-form.text :$entity label="Sprache" dbField='sprache' :$action />
