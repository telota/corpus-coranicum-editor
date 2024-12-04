@props(['entity'])
@php($category=\App\Enums\Category::GlossaryEvidence)
<x-index-item :text='$entity->id'/>
<x-index-item :text='$entity->eintrag->wort'/>
<x-index-item :text='$entity->eintrag->wurzel'/>
<x-index-item :text='$entity->typ'/>
<x-index-item
        :text='$entity->belegstelle'
        :link='route("show", ["category"=>$category, "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>
