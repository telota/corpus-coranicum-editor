<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity label='Repository (place name)' dbField='place_name' :$action/>
<x-form.text :$entity label='City (place)' dbField='place' :$action/>
<x-form.select-country :country='$entity->country_code' :$action/>
@php
$translations = \App\Models\Translation::all();
$options = $translations->mapWithKeys(fn($t)=>[$t->id=>$t->key])->sort()
        ->prepend("(No translation selected)", null);
@endphp
<x-form.select-relational
        label='Description'
        dbField='description_id'
        :$options
        :entities='$translations'
        :value='$entity->description_id'
        optionLabel='key'
        showComponent='translation-relational'
        :$action />
<x-form.text :$entity label='Link' dbField='link' :$action/>
<x-form.text :$entity label='Image Link' dbField='image_link' :$action/>
<x-form.text :$entity label='Image Original Link' dbField='image_original_link' :$action/>
<x-form.text :$entity label='Image Description' dbField='image_description' :$action/>
<x-form.text :$entity label='Longitude' dbField='longitude' :$action/>
<x-form.text :$entity label='Latitude' dbField='latitude' :$action/>
<x-form.text :$entity label='Geoname' dbField='geonames' :$action/>
<x-history :$entity :$action/>
