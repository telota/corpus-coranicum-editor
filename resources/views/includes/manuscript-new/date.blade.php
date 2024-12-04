<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">Date
            <span href="#" data-toggle="tooltip" title='Date format: YYYY-MM-dd (Y: Year, M: Month, d: day)'>
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span></div>
    </div>

    <div class="panel-body space-between">

        <span class="input-group">
            {!! Form::label("date_start", "Start") !!} &nbsp;
                {{--<input class="date form-control" id="date_start" name="date_start" type="text"--}}
                {{--value="{{$record->date_start ? $record->date_start : null}}">--}}
            {!!Form::number("date_start", $record->date_start, ["class" => "form-control" ])!!}
        </span>

        <span class="input-group">
            {!! Form::label("date_end", "End") !!} &nbsp;
            {{--<input class="date form-control" id="date_end" name="date_end" type="text"--}}
            {{--value="{{$record->date_end ? $record->date_end : null}}">--}}
            {!!Form::number("date_end", $record->date_end, ["class" => "form-control" ])!!}
        </span>

    </div>

</div>

