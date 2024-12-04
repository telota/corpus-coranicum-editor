@extends("layouts.master")

@section("title")
    <h1>
        Modules
        <a href="{{ URL::action([App\Http\Controllers\CCModuleController::class, 'create']) }}">
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
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($modules as $module)
            <tr>
                <td>{{ $module->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCModuleController::class, 'show'], $module->id) }}">
                        {{ $module->module_name }}
                    </a>
                </td>
                <td>
                    <div>{{  $module->module_description }}</div>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\CCModuleController::class, 'show'], $module->id) }}"
                           title="Module anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\CCModuleController::class, 'edit'], $module->id) }}"
                           title="Module bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                        </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
