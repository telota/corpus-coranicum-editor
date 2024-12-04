<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Function of the Reading Signs</div>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $i = 0;
            $functions = \App\Models\Manuscripts\ManuscriptNew::getReadingSignsFunctions();
            $j = ceil(count($functions) / 2);
            ?>
            @foreach( $functions as $function => $label)
                    @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">
                        {!! Form::label("reading_signs_functions[$function]", $label) !!} &nbsp;
                        {!! Form::checkbox(
                            "reading_signs_functions[$function]",
                            $label,
                            $record->readingSignsFunctions->where("function", $label)->count(),
                            [
                                "id" => str_replace(" ", "_", $function)
                            ]
                        ) !!}
                    </span>
                        @if(($i + 1) % $j == 0 | $i == count($functions) - 1)
                    </div>
                @endif
                <?php   $i++;  ?>
            @endforeach
        </div>
    </div>
</div>
