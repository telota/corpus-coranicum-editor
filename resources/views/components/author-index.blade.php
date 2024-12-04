@props(['entity'])
@php
$check = "<div style='text-align: center'>✔</div>";
$category=\App\Enums\Category::Author;
$editLink= Illuminate\Support\Facades\Auth::user()->isAdmin() ? $category->editLink()($entity->id) : null;
@endphp
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->author_name'
        :link='route("show", ["category"=>\App\Enums\Category::Author, "id"=>$entity->id])'
        :$editLink
/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "editor", "variants") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "collaborator", "variants") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "earlier_contributor", "variants") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "metadata", "manuscript") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "transliteration", "manuscript") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "image", "manuscript") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "translation", "manuscript") ? $check : ""'/>
<x-index-item :text='App\Models\GeneralCC\CCAuthor::hasRole($entity, "assistance", "manuscript") ? $check : ""'/>
