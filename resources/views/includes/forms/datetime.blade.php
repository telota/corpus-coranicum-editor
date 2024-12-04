<div class="input-group">
    {!! Form::label($label, ucfirst($label), array("class" => "input-group-addon")) !!}
    {!! Form::text(
        $label,
        trim(strip_tags($content)),
        array("class" => "datetime form-control","placeholder" => $content)
    ) !!}
</div>

