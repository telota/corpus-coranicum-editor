@extends("layouts.master")

@section("title")

    <h1>
        @if(empty($blog->title))
            Neuer Blogeintrag
        @else
            {{ $blog->title }}
        @endif
    </h1>

    @if(!empty($blog->title))

        <div>
            <small>
                Erstellt: {{ $blog->created_at }}
            </small>
        </div>
        <div>
            <small>
                Geändert: {{ $blog->updated_at }}
            </small>
        </div>


    @endif

@endsection

@section("content")

    {!! Form::model($blog, array("action" => $action)) !!}

        <div class="form-group">
            <label for="title">Titel</label>
            {!! Form::text("title", $blog->title, array("class" => "form-control"))  !!}
        </div>

        <div class="form-group">
            <label for="entry_content">Inhalt</label>
            {!! Form::textarea("entry_content",$blog->entry_content, array("class" => "summernote")) !!}
        </div>

    <hr>

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
        array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

@endsection