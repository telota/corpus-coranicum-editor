@extends("layouts.master")

@section("title")
    <h1>
        {{ $role->role_name . ' - ' . $role->module->module_name }}
        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'edit'], $role->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $role))

    <hr>
    <h2>
        Authors
        <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'create']) }}"
           title="Neuen Author hinzufügen">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h2>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>

        </tr>
        </thead>

        <tbody>
        @foreach($role->authors as $author)
            <tr>
                <td>
                    {{ $author->author->id }}
                </td>
                <td>
                    {{ $author->author->author_name }}
                    <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'],$author->author->id) }}"
                           title="Author anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'edit'], $author->author->id) }}"
                           title="Author bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>

                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection
