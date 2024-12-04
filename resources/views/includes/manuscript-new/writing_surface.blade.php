<div class="panel panel-default">

    <div class="panel-heading">
        {{--        <div class="panel-title">{{ ucfirst($label) }}</div>--}}
    </div>

    <div class="panel-body flex-column">

        <div class="space-between">
            @foreach(\App\Enums\WritingSurface::cases() as  $surface)
                <span class="input-group">
                    <label for='{{$surface->name}}' style='margin-right: 4px'>{{$surface->name}}</label>
                    <input type='radio' name='writing_surface' value='{{$surface->name}}'
                        {{ $record->writing_surface == $surface->name ? 'checked' : ''}}
                    >
            </span>
            @endforeach
            <span class="input-group">
                    <label for='other'>Other</label>
                    <input type='radio' name='writing_surface' value='Other'
                        {{ collect(\App\Enums\WritingSurface::cases())->contains(fn($v)=>$v->name == $record->writing_surface) ? '' : 'checked'}}
                    >
            </span>
        </div>
        <div>
            <br>
            <label for='writing_surface_other'>Other material</label>
            <input type='text'
                   name='writing_surface_other'
                   value='{{ collect(\App\Enums\WritingSurface::cases())->contains(fn($v)=>$v->name == $record->writing_surface) ? '' : $record->writing_surface}}'
            >
        </div>

        <div>
            <br>
            {{--            <div>--}}
            {{--                {!! Form::radio("writing_surface",--}}
            {{--                     "Parchment",--}}
            {{--                     !in_array($record->writing_surface,\App\Models\Manuscripts\ManuscriptNew::getWritingSurfaces())--}}
            {{--                 ) !!}--}}
            {{--                {!! Form::label($label, "Other :") !!}--}}
            {{--            </div>--}}
            {{--            {!! Form::text("writing_surface_text", trim(strip_tags($content)),  array("class" => "form-control")) !!}--}}

        </div>
    </div>

</div>
