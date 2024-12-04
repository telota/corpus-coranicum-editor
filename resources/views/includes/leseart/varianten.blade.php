@for($i = 1; $i <= $maxWort; $i++)

    <div class="input-group">
        {!! Form::label("variante[" . $i . "]", $i, array("class" => "input-group-addon")) !!}
        {!! Form::text("variante[" . $i . "]", "",  array("class" => "form-control")) !!}
        <span class="input-group-addon">{{ $words[$i-1]->transkription }}</span>
    </div>
@endfor