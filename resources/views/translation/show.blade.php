@extends("layouts.master")

@section("title")

    {{ $translation->key }}

    <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'edit'], $translation->key) }}">
        <span class="glyphicon glyphicon-pencil  glyphicon-hover"></span>
    </a>

@endsection

@section("content")


    <li class="list-group-item">
        <span class="label label-default">Deutsch</span>  {!! $translation->de !!}
    </li>
    <li class="list-group-item">
        <span class="label label-default">Englisch</span>  {!! $translation->en !!}
    </li>
    <li class="list-group-item">
        <span class="label label-default">Französisch</span>  {!! $translation->fr !!}
    </li>
    <li class="list-group-item">
        <span class="label label-default">Türkisch</span>  <span dir="rtl">{!! $translation->tr !!}</span>
    </li>
    <li class="list-group-item">
        <span class="label label-default">Arabisch</span>  <span dir="rtl">{!! $translation->ar !!}</span>
    </li>
    <li class="list-group-item">
        <span class="label label-default">Persisch</span>  <span dir="rtl">{!! $translation->fa !!}</span>
    </li>
    <li class="list-group-item">
        <span class="label label-default">Russisch</span>  <span dir="rtl">{!! $translation->ru !!}</span>
    </li>


@endsection