@props(['url'])
<img src="{{ $url }}"
     style="height: 300px">
<a href="{{$url}}" target="_blank">
    Open in a new window
    <span class="glyphicon glyphicon-new-window glyphicon-hover"></span>
</a>
<p>{{"($url)"}}</p>
