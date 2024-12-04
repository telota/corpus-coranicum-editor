@extends("layouts.master")

@section("title")
    <h1>
        Translation Languages
        <a href="{{ URL::action([App\Http\Controllers\CCTranslationLanguageController::class, 'create']) }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"
            title="Sprache hinzufügen"></span>
        </a>
    </h1>
@endsection

@section("content")

<table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
        @foreach($languages as $language)
            <tr>
                <td>{{ $language->id }}</td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCTranslationLanguageController::class, 'show'], $language->id) }}">
                        {{ $language->translation_language }}
                    </a>

                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\CCTranslationLanguageController::class, 'show'], $language->id) }}"
                           title="Sprache anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\CCTranslationLanguageController::class, 'edit'], $language->id) }}"
                           title="Sprache bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                        </span>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
