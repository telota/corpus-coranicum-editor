@extends("layouts.master")

@section("title")

    <h1>
        {{ empty($leseart->id) ? "Neue Leseart" : "Leseart " . $leseart->id }}
    </h1>

@endsection

@section("content")

    {{--    {!! Form::model($leseart, array("action" => $action)) !!}--}}

    <form action="{{$action}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if($leseart->id)
            <input name="_method" type="hidden" value="PUT">
        @endif

        <div class="input-form">
            <x-form.quran-verse
                    :sura='$leseart->sure'
                    :verse='$leseart->vers'
                    :action='App\Enums\FormAction::Create'
            />
        </div>

        @include("includes.forms.select", array(
            "label" => "Quelle",
            "options" => App\Models\Lesarten\Quelle::getAllSelect(),
            "default" => isset($leseart->quelle->id) ? $leseart->quelle->id : $quelle
        ))
        @include("includes.leseart.leser", array(
            "leseart" => $leseart
        ))

        @include("includes.forms.select", array(
           "label" => "Kanonisch",
           "options" => array(0 => "Nicht kanonisch", 1 => "Kanonisch"),
           "default" => $leseart->kanonisch
       ))

        @include("includes.forms.summernote", array(
            "label" => "kommentar",
            "content" => $leseart->kommentar
        ))

        @include("includes.forms.summernote", array(
            "label" => "kommentar_intern",
            "content" => $leseart->kommentar_intern
        ))

        <hr>

        <div class="panel panel-default">
            <div class="panel-heading">Varianten</div>
            <div class="panel-body" id="varianten">

                @for($i = 1; $i <= App\Models\Sure::getMaxWort($leseart->sure, $leseart->vers); $i++)
                    <div class="input-group">
                        {!! Form::label("variante[$i]", $i, array("class" => "input-group-addon")) !!}
                        {!! Form::text("variante[$i]", isset($leseart->variantenWort($i)->variante) ? $leseart->variantenWort($i)->variante : "",  array("class" => "form-control")) !!}
                        <span class="input-group-addon">{{ $words[$i-1]->transkription }}</span>
                    </div>
                @endfor

            </div>


        </div>

        <hr>

        {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
        array("class" => "btn btn-primary", "type" => "submit")) !!}

        @if($action == [LeseartenController::class, 'store'])

            <span class="pull-right">
            {!! Form::Button('Speichern & Nächste Leseart <i class="glyphicon glyphicon-chevron-right"></i>',
             array("class" => "btn btn-primary", "type" => "submit", "name" => "next", "value" => "true")) !!}
        </span>

        @endif

        {!! Form::close() !!}

        <div id="umwelttext-wrapper-main" class="hide">
            <div id="umwelttext-wrapper">
                {!! \Illuminate\Support\Facades\Storage::get("umwelttext/umwelttext.html") !!}
            </div>
        </div>

    </form>
@endsection