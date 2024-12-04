@extends("layouts.master")

@section("title")

    {{ $translation->key }}

@endsection

@section("content")

    {!! Form::model($translation, ["action" => ['App\Http\Controllers\TranslationController@update', $translation->key]])  !!}

    @include("includes.forms.summernote", array(
        "label" => "deutsch",
        "content" => $translation->de
    ))

    @include("includes.forms.summernote", array(
        "label" => "englisch",
        "content" => $translation->en
    ))

    @include("includes.forms.summernote", array(
        "label" => "französisch",
       "content" => $translation->fr
    ))
    @include("includes.forms.summernote", array(
        "label" => "türkisch",
        "content" => $translation->tr
    ))

    @include("includes.forms.summernote", array(
        "label" => "arabisch",
        "content" => $translation->ar
    ))

    @include("includes.forms.summernote", array(
        "label" => "persisch",
        "content" => $translation->fa
    ))
    @include("includes.forms.summernote", array(
        "label" => "russisch",
        "content" => $translation->ru
    ))

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}
    @include('components.summernote.zotero')
    @include('components.summernote.intertexts')

@endsection

