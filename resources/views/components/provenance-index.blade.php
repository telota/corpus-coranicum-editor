@props(['entity'])
@php($category=\App\Enums\Category::Provenance)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->provenance'
        :link='route("show", ["category"=>"provenance", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>