@php
    $manuscript_id = \Route::current()->parameter('manuscript_id');
    $page_id = \Route::current()->parameter('page_id');
@endphp
<div name="manuscript-image" style='margin: 2px 0px; padding: 4px; border-style: solid; border-width: 1px'>
    <h3 style='display:inline-block; margin-right: 2px'>
        Image {{$image->sort}}
        @if ($show_buttons)
            @include('edit_button', [
            'label' => 'Edit Image',
            'link' => route('ms_image.edit',[
                'manuscript_id'=> $manuscript_id,
            'page_id'=>$page_id,
            'image_id'=>$image->id
            ])
            ])
    </h3>
    <x-modal-button
            :id='"delete-image-" . $image->id'
            buttonClass='btn-danger modal-button'
            buttonMessage='Delete'
            buttonIcon='trash'
            title="Are you sure you want to delete this image?"
    >
        <x-slot:message>
            @if(isset($image->image_link))
                <p>
                    The underlying digilib file "{{$image->original_filename}}" will also be deleted.
                </p>
            @endif
        </x-slot:message>
        <x-slot:submit>
            <form style='display: inline'
                  action={{route('ms_image.delete', [
                                        'manuscript_id'=>$manuscript_id,
                                        'page_id'=>$page_id,
                                        'image_id'=>$image->id,
                                        ])}}
                                      method='POST'>
                {{ csrf_field() }}
                @method('DELETE')
                <button class="btn btn-danger" type='submit'>
                    <span class='glyphicon glyphicon-trash'></span>
                    Delete
                </button>
            </form>
        </x-slot:submit>
    </x-modal-button>
    @endif
    <x-entity :entity='$image' component='manuscript-image' formUrl=""
              :action='$action' :page='null'
    />
    <hr>
</div>
