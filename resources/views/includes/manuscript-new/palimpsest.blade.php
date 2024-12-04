<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body space-between">
        <span class="input-group">
            {!! Form::label($label, "yes") !!} &nbsp;
            @if ($record->palimpsest === "yes")
                <input name="palimpsest" type="radio" value="yes" id="palimpsest_yes" checked="checked">
            @else
                <input name="palimpsest" type="radio" value="yes" id="palimpsest_yes">
            @endif
        </span>
        <span class="input-group">
            {!! Form::label($label, "no") !!} &nbsp;
            @if ($record->palimpsest === "no" | $record->palimpsest === null)
                <input name="palimpsest" type="radio" value="no" id="palimpsest_no" checked="checked">
            @else
                <input name="palimpsest" type="radio" value="no" id="palimpsest_no">
            @endif
        </span>
    </div>
    <div id="palimpsest_text_area" class="panel-body">
        <hr>

        <label for="palimpsest_text">Palimpsest Text</label>

        <span class="btn btn-primary btn-xs summernote-activator"
              summernote-target="#{{ str_replace(" ", "_", "palimpsest_text") }}">
                <span class="glyphicon glyphicon-pencil"></span>
                Edit in Editor
            </span>

        <div class="panel-body">

            <div class="form-group">
                {!! Form::textarea("palimpsest_text", $record->palimpsest_text, array("class" => "", "id" => str_replace(" ", "_", "palimpsest_text"))) !!}
            </div>

        </div>
    </div>


</div>

<script type="text/javascript">

    if ($("#palimpsest_yes").attr("checked") == "checked")
        $('#palimpsest_text_area').show();
    else
        $('#palimpsest_text_area').hide();


    $("#palimpsest_yes").click(function () {
        $('#palimpsest_text_area').show();
    });

    $("#palimpsest_no").click(function () {
        $('#palimpsest_text_area').hide();
    });

</script>

