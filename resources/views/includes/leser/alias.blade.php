<div class="panel panel-default" id="panel-alias">
    <div class="panel-heading">Aliase vom Leser</div>
    <div class="panel-body">

        @foreach($leser->alias as $index => $alias)

            <div class="input-form input-alias">
                <h4>
                    Alias
                    <span class="label label-default">{{ ($index + 1) }} </span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    {!! Form::text("aliases[]", $alias->alias, array("class" => "form-control")) !!}
                </div>
                <hr>
                <div class="btn btn-danger remove-alias"><span class="glyphicon glyphicon-remove"></span> Alias entfernen</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-alias"><span class="glyphicon glyphicon-plus"></span> Alias hinzufügen</div>
    </div>
</div>