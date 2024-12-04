<div class="panel panel-default" id="panel-images">
    <div class="panel-heading">Bilder zum Umwelttext</div>
    <div class="panel-body">

        @foreach($umwelttext->images as $index => $image)

            <div class="input-form input-image">
                <h4>
                    Bild
                    <span class="label label-default">{{ ($index + 1) }} </span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    {!! Form::text("existing_images[]", $image->id, array("class" => "hide")) !!}

                    <a href="{{ Config::get("constants.digilib.scaler") . $image->bildlink . "&mo=ascale,1" }}" target="_blank">
                        <img src="{{ Config::get("constants.digilib.scaler") . $image->bildlink . "&dw=800" }}">
                    </a>

                    <div class="input-group">
                        {!! Form::label("bildnachweis_label", "Bildnachweis", array("class" => "input-group-addon")) !!}
                        {!! Form::text("bildnachweis[]", $image->bildnachweis, array("class" => "form-control", "placeholder" => "Bildnachweis")) !!}
                    </div>
                </div>
                <hr>
                <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Bild entfernen</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-image" route="umwelttexte"><span class="glyphicon glyphicon-plus"></span> Bild hinzufügen</div>
    </div>
</div>