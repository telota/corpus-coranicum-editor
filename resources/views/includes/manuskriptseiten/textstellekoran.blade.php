<div class="panel panel-default" id="panel-textstelle">
    <div class="panel-heading">Textstelle Koran</div>
    <div class="panel-body">

        @foreach($manuskriptseite->mappings as $index => $textstelle)

            <div class="input-form input__textstelle">
                <h4>
                    Textstelle
                    <span class="label label-default">{{ ($index + 1) }}</span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    <div class="form-group">
                        {{-- Iterate from sura 1 to 114 (max sura)--}}
                        {!! Form::label("sure_s", "Sure (Start)") !!}
                        {!! Form::select("sure_s[]", array_combine(range(1,114), range(1,114)), ltrim($textstelle["sure_start"], "0"), array("class" => "sureselect", "id" => "sure_s")) !!}

                        {{-- Iterate from verse counter 0 (min verse) to 286 (max max of all verses)--}}
                        {!! Form::label("vers_s", "Vers (Start)") !!}
                        {!! Form::select("vers_s[]", array_combine(range(0,286), range(0,286)), ltrim($textstelle["vers_start"], "0"), array("class" => "versselect", "id" => "vers_s")) !!}

                        {{-- Iterate from word counter 0 (min word) to 129 (max word)--}}
                        {!! Form::label("wort_s", "Wort (Start)") !!}
                        {!! Form::select("wort_s[]", array_combine(range(0,128), range(0,128)), ltrim($textstelle["wort_start"], "0"), array("class" => "wortselect", "id" => "wort_s")) !!}
                        <span class="arab arab-word"></span>
                    </div>
                    <div class="form-group">
                        {!! Form::label("sure_e", "Sure (Ende)") !!}
                        {!! Form::select("sure_e[]", array_combine(range(1,114), range(1,114)), ltrim($textstelle["sure_ende"], "0"), array("class" => "sureselect", "id" => "sure_e")) !!}

                        {!! Form::label("vers_e", "Vers (Ende)") !!}
                        {!! Form::select("vers_e[]", array_combine(range(0,286), range(0,286)), ltrim($textstelle["vers_ende"], "0"), array("class" => "versselect", "id" => "vers_e")) !!}

                        {!! Form::label("wort_e", "Wort (Ende)") !!}
                        {!! Form::select("wort_e[]", array_combine(range(0,128), range(0,128)), ltrim($textstelle["wort_ende"], "0"), array("class" => "wortselect", "id" => "wort_e")) !!}
                        <span class="arab arab-word"></span>

                    </div>
                </div>
                <div class="btn btn-danger remove-textstelle"><span class="glyphicon glyphicon-remove"></span> Textstelle entfernen</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-textstelle"><span class="glyphicon glyphicon-plus"></span> Weitere Textstelle</div>
    </div>
</div>
