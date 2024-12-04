@extends("layouts.master")

@section("title")

    <h1>{{ $blog->title }}
        <a href="{{ URL::action([App\Http\Controllers\BlogController::class, 'edit'], $blog->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
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
    <div>
        <small>
            Autor: {{ $blog->author }}
        </small>
    </div>

@endsection

@section("content")

    {!! $blog->entry_content !!}

@endsection