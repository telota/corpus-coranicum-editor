<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Kategorie</div>
    </div>
    <div class="panel-body">
        <div class="input-group">
            {!! Form::select("kategorie", \App\Models\Umwelttexte\BelegstellenKategorie::toSelectArray(), $record->kategorie) !!}
        </div>
    </div>
</div>