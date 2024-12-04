@props(['entity'])
@php($category=\App\Enums\Category::Place)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->place_name'
        :link='route("show", ["category"=>"place", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>
<x-index-item :text='$entity->place'/>
<x-index-item :text='$entity->country_code'/>
