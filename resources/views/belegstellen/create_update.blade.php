@extends("layouts.master")
@section("title")
    Kategorie erstellen
@endsection

@section("content")

    {!! Form::model($belegstellenKategorie, array("action" => $action)) !!}

    <div class="form-group">
        <label for="name">Name</label>
        {!! Form::text("name", $belegstellenKategorie->name, array("class" => "form-control")) !!}
    </div>

    <div class="form-group">
        <label for="supercategory">Oberkategorie</label>
        <select name="supercategory" class="form-control">
            @foreach($superKategorien as $kategorie)
                <option value="{{$kategorie[0]}}">{{$kategorie[1]}} (ID: {{$kategorie[0]}})</option>
            @endforeach
        </select>
    </div>

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

@endsection