<div class="input-group">

    {!! Form::file("Bildlink_file2", array("class" => "hidden", "id" => "bildlink2_upload"))  !!}
    <span class="input-group-btn">
        <label for="Bildlink2" class="btn btn-primary" type="button" id="bildlink2_upload_label">
            <span class="glyphicon glyphicon-upload"></span> Bildlink 2</label>
    </span>

    {!! Form::text($label, trim(strip_tags($content)),  array("class" => "form-control", "id" => "bildlink2_input")) !!}

</div>