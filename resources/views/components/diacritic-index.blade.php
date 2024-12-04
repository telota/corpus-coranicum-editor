@props(['entity'])
@php($category=\App\Enums\Category::Diacritic)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->diacritic'
        :link='route("show", ["category"=>"diacritic", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>