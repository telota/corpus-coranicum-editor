<h2>
    Transliteration

    <a href="{{ URL::action([App\Http\Controllers\TransliterationsEditorController::class, 'edit'], $manuskriptseite->SeitenID) }}">
    <span class="btn btn-primary">
            <span class="glyphicon glyphicon-pencil"></span> Edit Transliteration
        </span>
    </a>


        <div class="panel panel-default panel-primary" id="showTransliterations">
            <div class="panel-body">
                @foreach($transliterations as $line)
                <div class="lines well">
                    <div class="lineNumber">
                        {{$line->linenumber}}
                    </div>
                    <!-- Words in line, Buttons if activeLine, and Text if line is deactivated -->
                    <div class="lineContent showLines">
                        <p class="arab lineText" v-html="'{{$line->HTML}}'"></p>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
</h2>


