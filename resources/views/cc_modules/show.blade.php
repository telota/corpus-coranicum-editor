@extends("layouts.master")

@section("title")
    <h1>
        {{ $module->module_name }}
        <a href="{{ URL::action([App\Http\Controllers\CCModuleController::class, 'edit'], $module->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $module))

    <hr>
    <h2>
        Roles
        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'create']) }}"
           title="Neue Rolle hinzufügen">
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
        @foreach($module->roles as $role)
            <tr>
                <td>
                    {{ $role->id }}
                </td>
                <td>
                    {{ $role->role_name }}
                    <span class="pull-right">

                        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'show'],$role->id) }}"
                           title="Rolle anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\CCRoleController::class, 'edit'], $role->id) }}"
                           title="Rolle bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>

                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection
