@extends("layouts.master")

@section("title")
    <h1>
        {{ $author->author_name  }}
        <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'edit'], $author->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $author))

    <hr>
<h2>
    Roles
    <a href="{{ URL::action([App\Http\Controllers\CCAuthorRoleController::class, 'create'], $author->id) }}"
       title="Neue Rolle hinzufügen">
        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
    </a>
</h2>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Module</th>

        </tr>
        </thead>

        <tbody>
            @foreach($author->roles as $role)
            <tr>
                <td>
                    {{ $role->id }}
                </td>
                <td>
                        {{ $role->role->role_name }}
                </td>
                <td>
                    {{ $role->role->module->module_name }}
                    <?php
//                    dd($role->id);
                    ?>
{{--                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorRoleController::class, 'edit'], $role->id) }}">--}}
{{--                        <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>--}}
{{--                    </a>--}}
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

@endsection
