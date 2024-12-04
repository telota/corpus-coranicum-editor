@props(['entity', 'category'])
<x-index-item :text='$entity->id'/>
<x-index-item :text='$entity->typ'/>
<x-index-item
        :text='$entity->belegstelle'
        :link='route("show", ["category"=>\App\Enums\Category::GlossaryEvidence, "id"=>$entity->id])'
/>