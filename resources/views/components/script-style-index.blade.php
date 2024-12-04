@props(['entity'])
@php($category=\App\Enums\Category::ScriptStyle)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->style'
        :link='route("show", ["category"=>"script-style", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>