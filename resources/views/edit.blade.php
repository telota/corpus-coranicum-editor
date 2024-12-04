@extends("layouts.master")

@section("title")
    <h1>
        {{$entity[$category->singleTitle()]}}
    </h1>

@endsection
@section("content")
    <x-category-entity :$action :$entity :$category />
@endsection
