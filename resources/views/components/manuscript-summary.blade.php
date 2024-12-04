@props(['entity'])
<x-index-item :text='$entity->id'/>
<x-index-item
        :text='$entity->getName()'
        :link='route("manuscript.show", ["id"=>$entity->id])'
/>
@php
 switch($entity->is_online){
     case(0):
         $text='No';
         break;
     case(1):
         $text='Yes';
         break;
     default:
         $text="Error";

 }
@endphp
<x-index-item :$text />