<div class="panel panel-default">
<?php
    $contentForm = trim(strip_tags($content));
    if (str_contains($contentForm, ".")) {
        $four = explode(".",$contentForm)[0];
        $two = explode(".",$contentForm)[1];
    } else {
        $four = $contentForm;
        $two = 0;
    }


    ?>
    <div class="panel-heading">
        <div class="panel-title">Carbon Dating</div>
    </div>

    <div class="panel-body">
        <div class="row">

            <div class="col-md-6">

                <div class="input-group">
                    {!! Form::label("four digits for the carbon age") !!}

                    {!!Form::number("c_dating_four",
                        $four,
                        ["class" => "form-control", "placeholder" => "four digits for the carbon age" ])!!}

                </div>
                {!! Form::label(".") !!}
                <div class="input-group">
                    {!! Form::label("two digits standard deviation") !!}

                    {!!Form::number("c_dating_two",
                        $two,
                        ["class" => "form-control", "placeholder" => "two digits standard deviation" ])!!}

                </div>

        </div>

    </div>
    </div>

</div>

