@extends('layouts.master')

@section('title')
    <h1>
        {{ $page->manuscript->getName() }}
        <a href="{{ route('ms_page.show', ["manuscript_id" => $page->manuscript->id, "page_id"=>$page->id]) }}">
            - Folio {{ $page->folio . $page->page_side }}
        </a>
        <br>
        @if ($action == \App\Enums\FormAction::Create)
            -  New Image
        @else
            Image {{$image->sort}}
        @endif
    </h1>
@endsection

@section('content')
    <x-entity :entity='$image' component='manuscript-image' :formUrl="$formUrl"
              :action='$action'
    />
    @if(sizeof($other_images)>0)
        <h2>
            Other Images for {{ $page->folio . $page->page_side }}
        </h2>

        @foreach ($other_images as $image)
            @include('manuscript_page_image-relational',[
        'image'=>$image,
        'action'=>\App\Enums\FormAction::Show,
        'show_buttons'=>false,
        ])
        @endforeach
    @endif
@endsection
