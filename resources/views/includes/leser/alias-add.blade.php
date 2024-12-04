<div class="input-form input-alias">
    <h4>
        Alias
        <span class="label label-default">{{ $counter }} </span>
    </h4>
    <hr>
    <div class="form-horizontal">
        {!! Form::text("aliases[]", "", array("class" => "form-control")) !!}
    </div>
    <hr>
    <div class="btn btn-danger remove-alias"><span class="glyphicon glyphicon-remove"></span> Alias entfernen</div>
    <hr>
</div>