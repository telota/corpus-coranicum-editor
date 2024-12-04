<div class="input-form input-image">
    <h4>
        Bild
        <span class="label label-default">{{ $counter }}</span>
    </h4>
    <hr>
    <div class="form-horizontal">
        <div class="form-group">
             {!! Form::file("images[]") !!}
            <div class="input-group">
            {!! Form::label("bildnachweis", "", array("class" => "input-group-addon")) !!}
            {!! Form::text("bildnachweis[]", "", array("class" => "form-control", "placeholder" => "Bildnachweis")) !!}
            </div>
        </div>
    </div>
    <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Bild entfernen</div>
    <hr>
</div>