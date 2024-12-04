@props(['entity'])
@php($category=\App\Enums\Category::Attribution)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->person'
        :link='route("show", ["category"=>$category, "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>