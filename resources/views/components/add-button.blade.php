@if(isset($link))
    <a href="{{$link}}" title='{{$title}}'>
        <div class="btn btn-primary" id="{{ $id }}">
            <span class="glyphicon glyphicon-plus"></span> {{ $text }}
        </div>
    </a>
@else
    <div class="btn btn-primary" id="{{ $id }}" title='{{$title}}'>
        <span class="glyphicon glyphicon-plus"></span> {{ $text }}
    </div>
@endif
