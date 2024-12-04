@extends("layouts.master")

@section("title")
    <h1>
        Roles
        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"
                  title="Assistance hinzufügen"></span>
        </a>
    </h1>
@endsection

@section("content")

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Module</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'show'], $role->id) }}">
                        {{ $role->role_name }}
                    </a>
                </td>
                <td>
                    <div>{{  $role->module->module_name }}</div>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'show'], $role->id) }}"
                           title="Author anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'edit'], $role->id) }}"
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
