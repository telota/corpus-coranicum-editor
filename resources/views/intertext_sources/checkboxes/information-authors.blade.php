<div class="panel panel-default">

    <div class="panel-heading">
        <span class="panel-title">Author of Information</span>

        <span href="#" data-toggle="tooltip" title="Author role: intertext - information">
            <i class="fa fa-info-circle" style="color: #2e6da4" aria-hidden="true"></i>
        </span>
    </div>
    <div class="panel-body">
        <div class="space-between">
            <?php
            $i = 0;
            $authors = \App\Models\GeneralCC\CCAuthor::getAuthorsArray('intertext', 'information');
            //            $authors = \App\Models\Intertexts\InformationAuthor::getInfoAuthors();
            $j = ceil(count($authors) / 4);
            ?>
            @foreach( $authors as $author => $label)
                @if($i % $j == 0)
                    <div class="col-3">
                        @endif
                        <span class="input-group">

                {!! Form::label("info_authors[$label]", $author) !!} &nbsp;
                {!! Form::checkbox(
                    "info_authors[$label]",
                    $label,
                    $record->infoAuthors->where("info_author_id", $label)->count(),
                    [
                        "id" => str_replace(" ", "_", $label)
                    ]
                ) !!}

            </span>
                            <?php
//                      dd($label)
                            ?>
                        @if(($i + 1) % $j == 0 | $i == count($authors) - 1)
                    </div>
                @endif
                    <?php $i++; ?>
            @endforeach
        </div>
    </div>

</div>
