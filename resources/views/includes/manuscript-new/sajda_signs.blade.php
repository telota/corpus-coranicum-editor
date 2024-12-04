<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body space-between">
        <span class="input-group">
            {!! Form::label($label, "yes") !!} &nbsp;
            @if ($record->sajda_signs === "yes")
                <input name="sajda_signs" type="radio" value="yes" id="sajda_signs_yes" checked="checked">
            @else
                <input name="sajda_signs" type="radio" value="yes" id="sajda_signs_yes">
            @endif
        </span>
        <span class="input-group">
            {!! Form::label($label, "no") !!} &nbsp;
            @if ($record->sajda_signs === "no" | $record->sajda_signs === null)
                <input name="sajda_signs" type="radio" value="no" id="sajda_signs_no" checked="checked">
            @else
                <input name="sajda_signs" type="radio" value="no" id="sajda_signs_no">
            @endif
        </span>
    </div>
    <div id="sajda_signs_text_area" class="panel-body">
        <hr>

        <label for="sajda_signs_text">Sajda Signs Text</label>

        <span class="btn btn-primary btn-xs summernote-activator"
              summernote-target="#{{ str_replace(" ", "_", "sajda_signs_text") }}">
                <span class="glyphicon glyphicon-pencil"></span>
                Edit in Editor
            </span>

        <div class="panel-body">

            <div class="form-group">
                {!! Form::textarea("sajda_signs_text", $record->sajda_signs_text, array("class" => "", "id" => str_replace(" ", "_", "sajda_signs_text"))) !!}
            </div>

        </div>
    </div>


</div>

<script type="text/javascript">

    if ($("#sajda_signs_yes").attr("checked") == "checked")
        $('#sajda_signs_text_area').show();
    else
        $('#sajda_signs_text_area').hide();


    $("#sajda_signs_yes").click(function () {
        $('#sajda_signs_text_area').show();
    });

    $("#sajda_signs_no").click(function () {
        $('#sajda_signs_text_area').hide();
    });

</script>

