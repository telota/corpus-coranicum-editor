@props(['entity'])
@php($category=\App\Enums\Category::Funder)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->funder'
        :link='route("show", ["category"=>"funder", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>