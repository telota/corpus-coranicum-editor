@php
 $route = $disallow ? 'manuscript_images_restrict' : 'manuscript_images_allow';
@endphp
<form style='display: inline' action='{{route($route, ['id'=>$manuscriptId])}}' method='POST'>
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <button class="btn btn-primary" style="margin-left: 40px" type='submit'>
        <span class='glyphicon {{$disallow ? "glyphicon-arrow-down" : 'glyphicon-globe'}}'></span>
        {{ $disallow ? "Restrict All Images" : "Allow Images" }}
    </button>
</form>
