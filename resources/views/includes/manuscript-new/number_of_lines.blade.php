<div class="panel panel-default">
    <?php
    $contentForm = trim(strip_tags($content));
    if (str_contains($contentForm, "-")) {
        $explode = explode("-", $contentForm);
        $zeilenzahlContent = "";
        $min = str_replace(' ', '', $explode[0]);
        $max = str_replace(' ', '', $explode[1]);
    } else {
        $zeilenzahlContent = $contentForm;
        $min = 0;
        $max = 0;
    }

    ?>
    <div class="panel-heading">
        <div class="panel-title">{{ ucfirst($label) }}</div>
    </div>

    <div class="panel-body">
{{--        {!!Form::number("zeilenzahl",--}}
{{--            trim(strip_tags($content)),--}}
{{--            ["class" => "form-control", "placeholder" => "Zeilenzahl" ])!!}--}}

        <div class="row">

            <div class="col-md-6">

                <div class="input-group">
                    {!! Form::label("min_number_lines", "minimaler Zeilenzahl", ["class" => "input-group-addon"]) !!}
                    {!!Form::number("min_number_lines",
                        $min,
                        ["class" => "form-control", "placeholder" => "minimaler Zeilenzahl" ])!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    {!! Form::label("max_number_lines", "maximaler Zeilenzahl", ["class" => "input-group-addon"]) !!}
                    {!!Form::number("max_number_lines",
                        $max,
                        ["class" => "form-control", "placeholder" => "maximaler Zeilenzahl" ])!!}
                </div>
            </div>

        </div>

{{--        <hr>--}}

{{--        {!! Form::checkbox(--}}
{{--                  "irregular_number_lines",--}}
{{--                  "Unregelmäßiger Zeilenzahl",--}}
{{--                  $record->number_of_lines === "Unregelmäßiger Zeilenzahl"--}}
{{--              ) !!}--}}
{{--        {!! Form::label("Unregelmäßiger Zeilenzahl") !!}--}}


    </div>

</div>


