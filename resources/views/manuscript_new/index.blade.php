@extends('layouts.master')
@section('title')
    Handschriften Neu - Übersicht

    <a href="{{ route('manuscript.create') }}">
        <span class="glyphicon glyphicon-plus glyphicon-hover" title="Neue Manuskriptseite"></span>
    </a>
@endsection

@section('content')
    <?php $onlineString = [ 0 => 'No', 1 => 'Yes' ]; ?>
    <?php $noImages = [ 0 => '', 1 => ' (No Images)' ]; ?>
    <table class="table table-striped dataTable" data-toggle="table" data-row-style="rowStyle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Signatur</th>
                <th>Aufbewahrungsort</th>
                <th>Published</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($manuskripte as $manuskript)
                <tr>
                    <td>{{ $manuskript->id }}</td>
                    <td>
                        <a href="{{ route('manuscript.show', $manuskript->id) }}">
                            {{ $manuskript->call_number }}
                        </a>
                        <span class="pull-right">
                            <a href="{{ route('manuscript.show', $manuskript->id) }}"
                                title="Manuskript anzeigen">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                            </a>

                            <a href="{{ route('manuscript.edit', $manuskript->id) }}"
                                title="Manuskript bearbeiten">
                                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                            </a>

                            <a href="{{ route('manuscript.create', $manuskript->id) }}"
                                title="Manuskriptseite hinzufügen">
                                <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
                            </a>
                        </span>
                    </td>
                    <td>
                        @if($manuskript->place_id)
                        <a href="{{ route('show', ['category'=>\App\Enums\Category::Place, 'id'=>$manuskript->place_id]) }}">
                            {{ $manuskript->place ? $manuskript->place->place_name : "" }}
                        </a>
                        @endif
                    </td>
                    <td>{{ $onlineString[$manuskript->is_online] . $noImages[$manuskript->no_images]}}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
