@props(['entity'])
@php($category=\App\Enums\Category::AntiquityMarket)
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->antiquity_market'
        :link='route("show", ["category"=>"antiquity-market", "id"=>$entity->id])'
        :editLink='$category->editLink()($entity->id)'
/>