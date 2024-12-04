<div class="panel panel-default">
        <div class="panel-heading">
                <div class="panel-title">{{ ucfirst($label) }}</div>
        </div>
        <div class="panel-body">
                <div class="input-group">
                        {!! Form::select($label, $options, $default) !!}
                </div>
        </div>
</div>