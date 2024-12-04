@props(['entity', 'category'])
@php($category= $category ?? \App\Enums\Category::Veranstaltung)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->titel'
        :link='route("show", ["category"=>$category, "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>
<x-index-item :text='$entity->datum_start'/>
<x-index-item :text='$entity->ort'/>
