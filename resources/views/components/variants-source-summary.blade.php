@props(['entity'])
<x-index-item :text='$entity->id' :link='route("leseart.show",["id"=>$entity->id])' />
<x-index-item :text='$entity->leser->pluck("anzeigename")->implode(";\t")' />
<x-index-item :text='Str::padLeft($entity->sure,3,"0") . ":" . Str::padLeft($entity->vers,3,"0")' />
<x-index-item :text='$entity->kanonisch ? "ja" : "nein" '
              :editLink='route("lesearten.edit",["id"=>$entity->id])' />
