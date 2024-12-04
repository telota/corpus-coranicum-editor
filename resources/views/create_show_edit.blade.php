@extends("layouts.master")

@section("title")
    <a href='{{route('index', ['category'=>$category])}}'>
        <p>
            To {{$category->indexTitle()}}
            <x-icon type='th-list' />
        </p>
    </a>
    <h1>

        @if($action->value == 'create')
            New {{$category->emptyTitle()}}
        @else
            {{$entity[$category->singleTitle()]}}
            @if($action->value == 'show')
                @include('edit_button', [
                    'link' => $category->editLink()($id),
                    'label' => ''
                ])
            @endif
        @endif
    </h1>

@endsection
@section("content")
    <x-category-entity :$action :$entity :$category />
    @if($category->summaryRelations() && $action->value != 'create')
        @php($relation=$category->summaryRelations())
        <hr>
        <h3>{{$relation['title']}}
            @if($relation['addLink'] ?? null)
                <x-add-button
                        id=''
                        :title='"Create new " . $relation["addName"] ?? null'
                        :link='$relation["addLink"]($entity->id)'
                        :text='"New " . $relation["addName"] ?? null'
                />
            @endif
        </h3>
        <x-index-table
                :id='$relation["id"] ?? null'
                :columns='$relation["columns"]'
                :rowComponent='$relation["rowComponent"]'
                :entities='$entity[$relation["field"]]'
        />

    @endif
@endsection
