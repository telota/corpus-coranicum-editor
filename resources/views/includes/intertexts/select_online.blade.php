<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title">{{ ucfirst($label) }}</span>
        <span href="#" data-toggle="tooltip" title="Vorsicht beim Veröffentlichen des Umwelttextes!">
                    <i class="glyphicon glyphicon-warning-sign" style="color: red" aria-hidden="true"></i>
                  </span>
    </div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select($label, $options, $default) !!}
        </div>
    </div>
</div>
