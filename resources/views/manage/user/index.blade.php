@extends("layouts.master")

@section("title")
    <h1>
        Nutzer
        <a href="{{ URL::action([App\Http\Controllers\AdminController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Rolle</th>
        </tr>
        </thead>
        <tbody>

            @foreach($users as $user)

                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="{{ URL::action([App\Http\Controllers\AdminController::class, 'show'], $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <ul>
                        @if(sizeof($user->roles) == 0)
                            <li>Gast</li>
                        @else
                            @foreach($user->roles as $role)
                                <li>{{ $role->display_name }}</li>
                            @endforeach
                        @endif
                        </ul>
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endsection