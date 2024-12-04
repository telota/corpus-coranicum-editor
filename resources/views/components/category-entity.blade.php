@props(['entity','action','category'])
@php
    if($action == \App\Enums\FormAction::Edit){
        $form_url = route('replace_existing', ['category'=> $category->value, 'id'=>$entity->id]);
    }
    else if($action == \App\Enums\FormAction::Create){
        $form_url = route('store_new', ['category'=> $category->value]);
    }else{
        $form_url = "";
    }
//    dd($form_url)
@endphp
<x-entity :$entity :$action :formUrl='$form_url' :component='$category->value' />
