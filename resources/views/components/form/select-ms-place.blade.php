{{--Get rid of this as a separate component, once ManuscriptNew is revised--}}
@php
    $places = \App\Models\Manuscripts\Place::all();
    $options = $places->mapWithKeys(fn($item)=>[$item->id => $item->place . ", " . $item->place_name])->sort();
@endphp
<x-form.select-relational
        label='Place'
        :$action
        :entites='$places'
        :$options
        :value='$placeId'
        showComponent='place-relational'
        dbField='place_id' />
