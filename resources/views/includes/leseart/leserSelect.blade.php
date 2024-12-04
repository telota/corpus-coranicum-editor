@php
    $options = \App\Models\Lesarten\Leser::all()
        ->mapWithKeys(fn($l)=>[$l->id=>$l->sigle . " - " . $l->name ])
        ->sortby(fn($v)=>$v,SORT_NATURAL);
    $action = \App\Enums\FormAction::Edit;
@endphp
<div class='leser-input'>
    <x-form.datalist-input :label='"Leser " . $counter' :value='$default'
                   name='Leser[]'
                   :id='"leser_" . $counter'
                   :$options :$action
    />
    <div class="btn btn-danger remove-leser"><span class="glyphicon glyphicon-remove"></span> Leser entfernen</div>
    <hr>
</div>