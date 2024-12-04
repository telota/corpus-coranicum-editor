@if($action == \App\Enums\FormAction::Show)
    <table class="table">
        <tbody>
        <x-dynamic-component :component='$component' :$entity :$action />
        </tbody>
    </table>
@elseif($action == \App\Enums\FormAction::Create)
    <form action="{{$formUrl}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <x-dynamic-component :component='$component' :$entity :$action />
        @include('save_button')
    </form>
@elseif($action == \App\Enums\FormAction::Edit)
    <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <x-dynamic-component :component='$component' :$entity :$action />
        @include('save_button')
    </form>
@endif