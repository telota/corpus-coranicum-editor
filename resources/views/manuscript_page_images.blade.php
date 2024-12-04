<div id="manuscript-page-images" data-manuscript-id="{{ $page->manuscript->id }}"
     data-page-id="{{ $page->id }}">
    @if($page->id)
        <h2>Images
            @if($action == \App\Enums\FormAction::Show)

                <x-add-button id="add-image" text='Add Image'
                              :link='route("ms_image.create",["manuscript_id"=>$page->manuscript->id, "page_id"=>$page->id])' />
            @endif
        </h2>
        <br>
        <div id="image-list">

            @foreach ($page->images as $image)
                @include('manuscript_page_image-relational',[
            'image'=>$image,
            'action'=>\App\Enums\FormAction::Show,
            'show_buttons'=> $action == \App\Enums\FormAction::Show,
            ])
            @endforeach
        </div>
@endif
