<div class="input-form input__textstelle">
    <h4>
        Quran Text
        <span class="label label-default">{{ ($counter + 1) }}</span>
    </h4>
    <hr>
    <div class="form-horizontal">
        <div class="form-group">
            {{-- Iterate from sura 1 to 114 (max sura)--}}
            {!! Form::label("sure_s", "Sure (Start)") !!}
            {!! Form::select("sure_s[]", array_combine(range(1,114), range(1,114)), 1, array("class" => "sureselect", "id" => "sure_s")) !!}

            {{-- Iterate from verse counter 0 (min verse) to 286 (max max of all verses)--}}
            {!! Form::label("vers_s", "Vers (Start)") !!}
            {!! Form::select("vers_s[]", array_combine(range(0,7), range(0,7)), 1, array("class" => "versselect", "id" => "vers_s")) !!}

            {{-- Iterate from word counter 0 (min word) to 129 (max word)--}}
            {!! Form::label("wort_s", "Word (Start)") !!}
            {!! Form::select("wort_s[]", array_combine(range(0,129), range(0,129)), 0, array("class" => "wortselect", "id" => "wort_s")) !!}
            <span class="arab arab-word"></span>
        </div>
        <div class="form-group">
            {{-- Iterate from sura 1 to 114 (max sura)--}}
            {!! Form::label("sure_e", "Sure (End)") !!}
            {!! Form::select("sure_e[]", array_combine(range(1,114), range(1,114)), 1, array("class" => "sureselect", "id" => "sure_e")) !!}

            {{-- Iterate from verse counter 0 (min verse) to 286 (max max of all verses)--}}
            {!! Form::label("vers_e", "Vers (End)") !!}
            {!! Form::select("vers_e[]", array_combine(range(0,7), range(0,7)), 1 , array("class" => "versselect", "id" => "vers_e")) !!}

            {{-- Iterate from word counter 0 (min word) to 129 (max word)--}}
            {!! Form::label("wort_e", "Word (End)") !!}
            {!! Form::select("wort_e[]", array_combine(range(0,4), range(0,4)), 0, array("class" => "wortselect", "id" => "wort_e")) !!}
            <span class="arab arab-word"></span>
        </div>
    </div>
    <div class="btn btn-danger remove-textstelle"><span class="glyphicon glyphicon-remove"></span> Remove Quran Text</div>
    <hr>
</div>
