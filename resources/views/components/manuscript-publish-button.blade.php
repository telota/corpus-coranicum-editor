<h3>Status: {{$isOnline ? "Online" : "Offline"}} {{$noImages  && $isOnline ? " (without images)" : ""}}
    {{!$noImages  && $isOnline ? " (with images)" : ""}}
    @if(auth()->user()->isAdmin())
        <form style='display: inline' action='{{route('manuscript_publish')}}' method='POST'>
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            <input type='hidden' name='manuscript_id' value='{{$id}}' is_online='{{!$isOnline}}' />
            <input type='hidden' name='is_online' value='{{$isOnline ? 0 : 1 }}' />
            <button class="btn btn-primary" type='submit'>
                <span class='glyphicon {{$isOnline ? "glyphicon-arrow-down" : 'glyphicon-globe'}}'></span>
                {{ $isOnline ? "Take offline" : "Publish" }}
            </button>
        </form>
    @endif
</h3>