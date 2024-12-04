<x-modal-button
        id='unpublish-pages'
        buttonClass='btn-primary'
        buttonMessage='Make all Pages Private '
        buttonIcon='lock'
        title="Are you sure you want to make all pages for this manuscript private?"
>
    <x-slot:submit>
        <form style='display: inline'
              action={{route('manuscript_pages_unpublish', ['id'=>$manuscriptId])}} method='POST'>
            {{ csrf_field() }}
            @method('PUT')
            <button class="btn btn-primary" type='submit'>
                Yes
            </button>
        </form>
    </x-slot:submit>
    <x-slot:message></x-slot:message>
</x-modal-button>