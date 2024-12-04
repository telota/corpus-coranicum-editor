@php($action=\App\Enums\FormAction::Show)

@if(isset($entity))
    <table class='showRelationalEntity'>
        <tr>
            <td>Id</td>
            <td>
                <a href='{{route('show',['category'=>\App\Enums\Category::GlossaryEntry, 'id'=>$entity->id])}}'>
                    {{$entity->id}}
                </a>
            </td>
        </tr>
        <x-form.text :$entity label="Wort" dbField='wort' :$action />
        <x-form.text :$entity label="Wurzel" dbField='wurzel' :$action />
    </table>
@endif
