@props(['entity'])
@php($category=\App\Enums\Category::ReadingSign)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->reading_sign'
        :link='route("show", ["category"=>"reading-sign", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>