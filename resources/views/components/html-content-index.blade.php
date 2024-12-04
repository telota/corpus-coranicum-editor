@props(['entity'])
@php($category=\App\Enums\Category::HtmlContent)
<x-index-item :text='$entity->label'
              :link='route("show", ["category"=>$category, "id"=>$entity->id])'
              :editLink='$category->editLink()($entity->id)'
/>
<x-index-item :text='$entity->de'/>