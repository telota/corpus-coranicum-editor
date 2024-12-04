<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
      rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/gh/abublihi/datepicker-hijri@v1.1/build/datepicker-hijri.js"></script>

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body space-between">
        <span class="input-group">
            {!! Form::label($label, "yes") !!} &nbsp;
            @if ($record->colophon === "yes")
                <input name="colophon" type="radio" value="yes" id="colophon_yes" checked="checked">
            @else
                <input name="colophon" type="radio" value="yes" id="colophon_yes">
            @endif
        </span>
        <span class="input-group">
            {!! Form::label($label, "no") !!} &nbsp;
            @if ($record->colophon === "no" | $record->colophon === null)
                <input name="colophon" type="radio" value="no" id="colophon_no" checked="checked">
            @else
                <input name="colophon" type="radio" value="no" id="colophon_no">
            @endif
        </span>
    </div>
    <div id="colophon_text_area" class="panel-body">
        <hr>

        <label for="colophon_text">Colophon Text</label>

        <span class="btn btn-primary btn-xs summernote-activator"
              summernote-target="#{{ str_replace(" ", "_", "colophon_text") }}">
                <span class="glyphicon glyphicon-pencil"></span>
                Edit in Editor
            </span>

        <div class="panel-body">

            <div class="form-group">
                {!! Form::textarea("colophon_text", $record->colophon_text, array("class" => "", "id" => str_replace(" ", "_", "colophon_text"))) !!}
            </div>

        </div>
        <hr>

        <label>Colophon Date</label>
        <span href="#" data-toggle="tooltip" title='Date format: YYYY-MM-dd (Y: Year, M: Month, d: day)'>
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
        <div id="colophon_date">

        <div class="panel-body space-between">

        <span class="input-group">
                    {!! Form::label("colophon_date_option", "Gregorian Calendar") !!} &nbsp;

         <input type="radio" name="colophon_date_option" value="gregorian" id="colophon-gregorian" >
    </span>

            <span class="input-group">
                {!! Form::label("colophon_date_option", "Hijri Calendar") !!} &nbsp;

            <input type="radio" name="colophon_date_option" value="hijri" id="colophon-hijri" checked="checked">
    </span>
        </div>
        <hr>

        <div id="colophon-hijri-calendar">

            <?php
            $hijriDateStart = $record->colophon_date_start ? \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($record->colophon_date_start) : "0000-00-00";
            $hijriDateEnd = $record->colophon_date_end ? \App\Models\Manuscripts\ManuscriptNew::gregorianToHijriDate($record->colophon_date_end) : "0000-00-00";
            ?>

            <div class="panel-body space-between" style="margin: 1em;">
                <span class="input-group">
                 {!! Form::label("colophon_date_start_hijri", "Start") !!} &nbsp;
                    <input class="form-control" type="text" id="colophon_date_start_hijri" name="colophon_date_start_hijri"
                        value="{{$hijriDateStart}}">
                    <datepicker-hijri reference="colophon_date_start_hijri" placement="bottom" date-format="iYYYY-iMM-iDD"
                          selected-date="{{$hijriDateStart}}"></datepicker-hijri>
                </span>

                <span class="input-group">
                  {!! Form::label("colophon_date_end_hijri", "End") !!} &nbsp;
                    <input class="form-control" type="text" id="colophon_date_end_hijri" name="colophon_date_end_hijri"
                        value="{{$hijriDateEnd}}">
                    <datepicker-hijri reference="colophon_date_end_hijri" placement="bottom" date-format="iYYYY-iMM-iDD"
                          selected-date="{{$hijriDateEnd}}"></datepicker-hijri>
                </span>

            </div>
        </div>

        <div id="colophon-gregorian-calendar">

            <div class="panel-body space-between">
                <span class="input-group">
                    {!! Form::label("colophon_date_start", "Start") !!} &nbsp;
                    <input class="date form-control" id="colophon_date_start" name="colophon_date_start" type="text"
                   value="{{$record->colophon_date_start ? $record->colophon_date_start : null}}">
                </span>

                <span class="input-group">
                    {!! Form::label("colophon_date_end", "End") !!} &nbsp;
                    <input class="date form-control" id="colophon_date_end" name="colophon_date_end" type="text"
                   value="{{$record->colophon_date_end ? $record->colophon_date_end : null}}">
                </span>

            </div>
        </div>
    </div>
    </div>

</div>

<script type="text/javascript">

    if ($("#colophon_yes").attr("checked") == "checked")
        $('#colophon_text_area').show();
    else
        $('#colophon_text_area').hide();


    $("#colophon_yes").click(function () {
        $('#colophon_text_area').show();
    });

    $("#colophon_no").click(function () {
        $('#colophon_text_area').hide();
    });

    $('.date')
        .datepicker({

            format: 'yyyy-mm-dd'

        });

    if ($("#colophon-gregorian").attr("checked") == "checked")
    {
        $('#colophon-gregorian-calendar').show();
        $('#colophon-hijri-calendar').hide();
    }
    else
    {
        $('#colophon-gregorian-calendar').hide();
        $('#colophon-hijri-calendar').show();
    }


    $("#colophon-gregorian").click(function () {
        $('#colophon-gregorian-calendar').show();
        $('#colophon-hijri-calendar').hide();
    });

    $("#colophon-hijri").click(function () {
        $('#colophon-gregorian-calendar').hide();
        $('#colophon-hijri-calendar').show();
    });
</script>

