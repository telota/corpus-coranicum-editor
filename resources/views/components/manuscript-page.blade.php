@props(['entity','action'])
@php
    $pageOptions = collect([
                "r" => "r",
                "v" => "v",
                "bis" => "bis",
                "bis r" => "bis r",
                "bis v" => "bis v",
                "ter" => "ter",
                "ter r" => "ter r",
                "ter v" => "ter v",
                "" => "keine Angabe",
    ]);

@endphp

<x-form.number :$entity label='Folio' dbField='folio' :$action />
<x-form.select label='Side' name='page_side' :options='$pageOptions' :value='$entity->page_side' :$action />
<x-form.quran-mappings :$action :mappings='collect($entity->mappings)'/>
<x-form.radio-buttons name='is_online' label='Is Online'
                      :options='collect([0=>"No", 1=>"Yes"])'
                      :selected='(int)$entity->is_online' :$action />
<x-history :$entity :$action/>
