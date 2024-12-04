

    {!! Form::model($manuskriptOriginalCodex, array("action" => $action)) !!}

    <div class="form-group">
        <label for="name">Name</label>
        {!! Form::text("original_codex_name", $manuskriptOriginalCodex->original_codex_name, array("class" => "form-control")) !!}
    </div>

    <div class="form-group">
        <label for="supercategory">Oberkategorie</label>

        <select name="supercategory" class="form-control">
            @foreach($superKategorien as $kategorie)
                @if($kategorie == $manuskriptOriginalCodex->superCategory)
                    <option selected="selected" value="{{$kategorie[0]}}">{{$kategorie[1]}} (ID: {{$kategorie[0]}})</option>
                @else
                    <option value="{{$kategorie[0]}}">{{$kategorie[1]}} (ID: {{$kategorie[0]}})</option>
                @endif
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="script_style_id">Script Style</label>
        <select name="script_style_id" class="form-control">
            @foreach(\App\Models\Manuscripts\ScriptStyle::all() as $scriptStyle)
                @if($scriptStyle == $manuskriptOriginalCodex->scriptStyle)
                    <option selected="selected" value="{{$scriptStyle->id}}">{{$scriptStyle->style}} (ID: {{$scriptStyle->id}})</option>
                @else
                    <option value="{{$scriptStyle->id}}">{{$scriptStyle->style}} (ID: {{$scriptStyle->id}})</option>
                @endif
            @endforeach
        </select>
    </div>

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

