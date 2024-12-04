<div class="panel panel-default" id="panel-images">
    <div class="panel-heading">Bilder zur Manuskriptseite</div>
    <div class="panel-body">

        @foreach($manuskriptseite->bilder->sortBy('sort') as $image)

            <div class="input-form input-image">
                <h4>
                    Bild
                    <span class="label label-default">{{ $image->sort }} </span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    {!! Form::text("existing_images[]", $image->id, array("class" => "hide")) !!}

                    <a href="{{ $image->fullPath }}" target="_blank">
                        <img src="{{ $image->scalerPath }}">
                    </a>

                    <div class="input-group">
                        {!! Form::label("bildlinknachweis_label", "Bildnachweis", array("class" => "input-group-addon")) !!}
                        {!! Form::text("bildlinknachweis[]", $image->Bildlinknachweis, array("class" => "form-control", "placeholder" => "Bildnachweis")) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label("bildlink_extern_label", "Bildlink (extern)", array("class" => "input-group-addon")) !!}
                        {!! Form::text("bildlink_extern[]", $image->Bildlink_extern, array("class" => "form-control", "placeholder" => "Bildlink (extern)")) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label("sort", "Sort", array("class" => "input-group-addon")) !!}
                        {!! Form::number("sort[]", $image->sort, array("class" => "form-control", "placeholder" => "Sort")) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label("bildlink_webtauglich_label", "Webtauglich", array("class" => "input-group-addon")) !!}
                        {!! Form::select("bildlink_webtauglich[]", array("ja" => "ja", "nein" => "nein"), $image->webtauglich) !!}
                    </div>

                </div>
                <hr>
                <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Bild entfernen</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-image" route="manuskriptseiten"><span class="glyphicon glyphicon-plus"></span> Bild hinzufügen</div>
    </div>
</div>
