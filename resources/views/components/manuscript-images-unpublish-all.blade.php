<x-modal-button
        id='unpublish-images'
        buttonClass='btn-primary'
        buttonMessage='Make all Images Private '
        buttonIcon='arrow-down'
        title="Are you sure you want to make all images for this manuscript private?"
>
    <x-slot:submit>
        <form style='display: inline'
              action={{route('manuscript_images_unpublish', ['id'=>$manuscriptId])}} method='POST'>
            {{ csrf_field() }}
            @method('PUT')
            <button class="btn btn-primary" type='submit'>
                Yes
            </button>
        </form>
    </x-slot:submit>
    <x-slot:message></x-slot:message>
</x-modal-button>
