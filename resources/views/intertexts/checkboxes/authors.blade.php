<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Bearbeiter</div>
    </div>


    {{--    Metadata--}}
    <div class="panel-heading">
        <span class="panel-title">Author of TUK</span>
        <span href="#" data-toggle="tooltip" title="Author role: intertext - metadata">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $authors = \App\Models\GeneralCC\CCAuthor::getAuthorsArray('intertext', 'metadata');
            $i = 0;
            $j = ceil(count($authors) / 4);
            ?>
            @foreach( $authors as $author => $label)
                @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">

                {!! Form::label("authors[$author]", $author) !!} &nbsp;
                {!! Form::checkbox(
                    "authors[$author]",
                    $label,
                    $record->authors->where("author_id", $label)->count(),
                    [
                        "id" => str_replace(" ", "_", $author)
                    ]
                ) !!}

            </span>
                        @if(($i + 1) % $j == 0 | $i == count($authors) - 1)
                    </div>
                @endif
                    <?php $i++; ?>
            @endforeach
        </div>
    </div>


    {{--    Collaborators--}}

    <div class="panel-heading">
        <span class="panel-title">In Collaboration With</span>
        <span href="#" data-toggle="tooltip" title="Author role: intertext - collaboration">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $collaborators = \App\Models\GeneralCC\CCAuthor::getAuthorsArray('intertext', 'collaboration');
            $i = 0;
            $j = ceil(count($collaborators) / 4);
            ?>
            @foreach( $collaborators as $collaborator => $label)
                @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">

                {!! Form::label("collaborators[$collaborator]", $collaborator) !!} &nbsp;
                {!! Form::checkbox(
                    "collaborators[$collaborator]",
                    $label,
                    $record->collaborators->where("author_id", $label)->count(),
                    [
                        "id" => str_replace(" ", "_", $collaborator)
                    ]
                ) !!}

            </span>
                        @if(($i + 1) % $j == 0 | $i == count($collaborators) - 1)
                    </div>
                @endif
                    <?php $i++; ?>
            @endforeach
        </div>
    </div>

    {{--    Updaters--}}

    <div class="panel-heading">
        <span class="panel-title">Updated by</span>
        <span href="#" data-toggle="tooltip" title="Author role: intertext - update">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $updaters = \App\Models\GeneralCC\CCAuthor::getAuthorsArray('intertext', 'update');
            $i = 0;
            $j = ceil(count($updaters) / 4);
            ?>
            @foreach( $updaters as $updater => $label)
                @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">

                {!! Form::label("updaters[$updater]", $updater) !!} &nbsp;
                {!! Form::checkbox(
                    "updaters[$updater]",
                    $label,
                    $record->updaters->where("author_id", $label)->count(),
                    [
                        "id" => str_replace(" ", "_", $updater)
                    ]
                ) !!}

            </span>
                        @if(($i + 1) % $j == 0 | $i == count($updaters) - 1)
                    </div>
                @endif
                    <?php $i++; ?>
            @endforeach
        </div>
    </div>


    {{--Text Editing--}}

    <div class="panel-heading">
        <span class="panel-title">Text Editing</span>
        <span href="#" data-toggle="tooltip" title="Author role: intertext - text_editing">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $textEditings = \App\Models\GeneralCC\CCAuthor::getAuthorsArray('intertext', 'text_editing');
            $i = 0;
            $j = ceil(count($textEditings) / 4);
            ?>
            @foreach( $textEditings as $textEditing => $label)
                @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">

                {!! Form::label("text_editing[$textEditing]", $textEditing) !!} &nbsp;
                            {!! Form::checkbox(
                                "text_editing[$textEditing]",
                                $label,
                                $record->textEditing->where("author_id", $label)->count(),
                                [
                                    "id" => str_replace(" ", "_", $textEditing)
                                ]
                            ) !!}

            </span>
                        @if(($i + 1) % $j == 0 | $i == count($textEditings) - 1)
                    </div>
                @endif
                    <?php $i++; ?>
            @endforeach
        </div>
    </div>


</div>
