<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title">Translator</span>

        <span href="#" data-toggle="tooltip" title="Author role: intertext - translation">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>

    <div class="panel-body space-between">
        <?php
        $translators = \App\Models\GeneralCC\CCAuthor::getAuthorsArraySelect('intertext', 'translation');
        ?>
        <div>
            {!! Form::label("translator_id", "Translator") !!}
            {!! Form::select(
                "translator_id",
                $translators,
                $record->translator_id,
                [ "class" => "custom-select", "id" => "translator"]
                ) !!}

        </div>


    </div>
</div>
