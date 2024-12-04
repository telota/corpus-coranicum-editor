@props(['entity'])
@php($category=\App\Enums\Category::Quelle)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->anzeigetitel'
        :link='route("show", ["category"=>$category, "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>
<x-index-item :text='$entity->abkuerzung'/>
<x-index-item :text='sizeof($entity->lesarten)'/>
