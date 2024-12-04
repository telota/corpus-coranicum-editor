@extends("layouts.master")
@section("title")
    Intertext Categories
    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'create'])}}">
                        <span class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil"></span> Neu
                        </span>
    </a>
@endsection

@section("content")
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Oberkategorie</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            @if($category->id > 1)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->category_name}}</td>
                <td>
                    @foreach($categories as $supercategory)
                        @if($supercategory->id == $category->supercategory)
                            @if($supercategory->id == 1)
                                Oberkategorie
                            @else
                                {{$supercategory->category_name}} (ID: {{$supercategory->id}})
                            @endif
                        @endif

                    @endforeach
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'show'], $category->id) }}"
                       title="Kategorie anzeigen">
                        <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                    </a>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'edit'], $category->id)}}">
                        <span class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil"></span> Bearbeiten
                        </span>
                    </a>
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
