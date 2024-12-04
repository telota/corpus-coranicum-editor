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
                {!! Form::label("bildlinknachweis", "", array("class" => "input-group-addon")) !!}
                {!! Form::text("bildlinknachweis[]", "", array("class" => "form-control", "placeholder" => "Bildnachweis")) !!}
            </div>

            <div class="input-group">
                {!! Form::label("bildlink_extern_label", "Bildlink (extern)", array("class" => "input-group-addon")) !!}
                {!! Form::text("bildlink_extern[]", "", array("class" => "form-control", "placeholder" => "Bildlink (extern)")) !!}
            </div>

            <div class="input-group">
                {!! Form::label("sort", "Sort", array("class" => "input-group-addon")) !!}
                {!! Form::number("sort[]", $counter, array("class" => "form-control", "placeholder" => "Sort")) !!}
            </div>

            <div class="input-group">
                {!! Form::label("bildlink_webtauglich_label", "Webtauglich", array("class" => "input-group-addon")) !!}
                {!! Form::select("bildlink_webtauglich[]", array("ja" => "ja", "nein" => "nein"), "nein") !!}
            </div>

        </div>
    </div>
    <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Bild entfernen</div>
    <hr>
</div>