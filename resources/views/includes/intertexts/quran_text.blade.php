<div class="panel panel-default" id="panel-textstelle">
    <div class="panel-heading">Quran Texts</div>
    <div class="panel-body">

        @foreach($intertext->quranTexts as $index => $textstelle)

            <div class="input-form input__textstelle hide">
                <h4 class="Textstelle__title">
                    Quran Text
                    <span class="label label-default">{{ ($index + 1) }}</span>
                    <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>

                </h4>
                <hr>
                <div class="form-horizontal Textstelle__placeholder">

                    {{ str_pad($textstelle["sure_start"], 3, 0, STR_PAD_LEFT) }}:{{ str_pad($textstelle["vers_start"], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($textstelle["sure_end"], 3, 0, STR_PAD_LEFT) }}:{{ str_pad($textstelle["vers_end"], 3, 0, STR_PAD_LEFT) }}

                    <hr>

                </div>

                <div class="form-horizontal textstelle">
                    <div class="form-group">
                        {!! Form::label("sure_s", "Sure (Start)") !!}
                        {!! Form::select("sure_s[]", array_combine(range(1,114), range(1,114)), ltrim($textstelle["sure_start"], "0"), array("id" => "sure_s")) !!}

                        {!! Form::label("vers_s", "Vers (Start)") !!}
                        {!! Form::select("vers_s[]", array_combine(range(1,286), range(1,286)), ltrim($textstelle["vers_start"], "0"), array("class" => "versselect", "id" => "vers_s")) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label("sure_e", "Sure (End)") !!}
                        {!! Form::select("sure_e[]", array_combine(range(1,114), range(1,114)), ltrim($textstelle["sure_end"], "0"), array("id" => "sure_e")) !!}

                        {!! Form::label("vers_e", "Vers (End)") !!}
                        {!! Form::select("vers_e[]", array_combine(range(1,286), range(1,286)), ltrim($textstelle["vers_end"], "0"), array("class" => "versselect", "id" => "vers_e")) !!}
                    </div>
                </div>
                <div class="btn btn-danger remove-textstelle"><span class="glyphicon glyphicon-remove"></span> Remove Quran Text</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-textstelle"><span class="glyphicon glyphicon-plus"></span> Add Quran Text</div>
    </div>
</div>
