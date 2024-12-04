@extends('layouts.master')

@section('title')
    <h1>
        <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $page->manuscript->id) }}">
            {{ $page->manuscript->getName() }}
        </a>
        @if ($action == \App\Enums\FormAction::Create)
            - Neue Manuskriptseite
        @else
            - Folio {{ $page->folio . $page->page_side }}
        @endif
        @if ($action == \App\Enums\FormAction::Show)
            @include('edit_button', [
                'link' => URL::action([App\Http\Controllers\ManuscriptPageController::class, 'edit'], [
                    'manuscript_id' => $page->manuscript->id,
                    'page_id' => $page->id,
                ]),
                'label' => 'Edit Manuscript Page',
            ])
        @endif
    </h1>
@endsection

@section('content')
    @include('manuscript_pages.browse')
    <hr>
    <x-entity component='manuscript-page' :$action :entity='$page' :formUrl='$form_action ?? "" ' />
    <br>
    @include('manuscript_page_images', ['action'=>$action])

@endsection
