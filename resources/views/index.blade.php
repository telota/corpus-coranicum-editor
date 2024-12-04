@extends("layouts.master")

@section("title")
    <h1>
        {{$category->indexTitle()}}
        <x-add-button
                :id='$category->value . "_add" '
                :title='"Create new " . $category->value'
                :link='$category->addLink()'
                text='New Item'
        />
    </h1>

@endsection
@section("content")
    <x-category-index-table :$entities :$category />

@endsection
