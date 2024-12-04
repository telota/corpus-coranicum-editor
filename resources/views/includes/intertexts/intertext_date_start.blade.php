<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">Date</div>
    </div>

    <div class="panel-body space-between">

        <span class="input-group">
            {!! Form::label("intertext_date_start", "Start") !!} &nbsp;
            <input class="form-control" name="intertext_date_start" type="text" value="{{$intertext->intertext_date_start ? $intertext->intertext_date_start : ""}}">
        </span>

        <span class="input-group">
            {!! Form::label("intertext_date_end", "End") !!} &nbsp;
            <input class="form-control" name="intertext_date_end" type="text" value="{{$intertext->intertext_date_end ? $intertext->intertext_date_end : ""}}">
        </span>

    </div>

</div>
