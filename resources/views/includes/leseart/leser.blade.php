<div style='margin-bottom: 20px'>
    <h3>Leser</h3>

    @if(count($leseart->leser) > 0)
        @foreach($leseart->leser as $index => $leser)
            @include("includes.leseart.leserSelect", array(
                "default" => $leser->id,
                "counter" => $index+1
            ))
        @endforeach
    @else
        @include("includes.leseart.leserSelect", array(
            "default" => null,
            "counter" => 1
        ))

    @endif

    <div class="btn btn-primary" id="add-leser"><span class="glyphicon glyphicon-plus"></span> Weiterer Leser</div>
</div>