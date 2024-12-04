<div class="input-group">

    {!! Form::file("Bildlink_file", array("class" => "hidden", "id" => "bildlink_upload"))  !!}
    <span class="input-group-btn">
        <label for="Bildlink" class="btn btn-primary" type="button" id="bildlink_upload_label">
            <span class="glyphicon glyphicon-upload"></span> Bildlink</label>
    </span>

    {!! Form::text($label, trim(strip_tags($content)),  array("class" => "form-control", "id" => "bildlink_input")) !!}

</div>