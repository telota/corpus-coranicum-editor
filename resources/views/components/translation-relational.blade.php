@props(['entity'])
@if(isset($entity))
<table class='showRelationalEntity'>
    <tr>
        <td>Key</td>
        <td><a href='{{route('show_translation',["key"=>$entity->key])}}'>{{$entity->key}}</a></td>
    </tr>
    <tr>
        <td>DE</td>
        <td>{!! $entity->de!!}</td>
    </tr>
    <tr>
        <td>EN</td>
        <td>{!!$entity->en!!}</td>
    </tr>
    <tr>
        <td>FR</td>
        <td>{!!$entity->fr!!}</td>
    </tr>
</table>
@endif
