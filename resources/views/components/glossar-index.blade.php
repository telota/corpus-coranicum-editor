@props(['entity'])
@php($category=\App\Enums\Category::GlossaryEntry)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->wort'
        :link='route("show", ["category"=>$category, "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>
<x-index-item :text='$entity->wurzel'/>
<x-index-item :text='sizeof($entity->belege)'/>
<x-index-item :text='$entity->literatur'/>
