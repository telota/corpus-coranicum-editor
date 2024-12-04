@extends("layouts.master")

@section("title")

    Übersetzungen
    <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'create']) }}"
       title="Neues Übersetzungslabel">
        <span class="glyphicon glyphicon-hover glyphicon-plus"></span>
    </a>

    <span class="pull-right">
        <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'export'], "de") }}">
            <div class="btn btn-primary">
                <span class="glyphicon glyphicon-download"></span>
                Deutsch
            </div>
        </a>

        <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'export'], "en") }}">
            <div class="btn btn-primary">
                <span class="glyphicon glyphicon-download"></span>
                Englisch
            </div>
        </a>

        <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'export'], "fr") }}">
            <div class="btn btn-primary">
                <span class="glyphicon glyphicon-download"></span>
                Französisch
            </div>
        </a>

    </span>

@endsection

@section("content")

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">

        <thead>
        <tr>
            <th>Label</th>
            <th>Deutsch</th>
            <th>English</th>
            <th>Français</th>
            <th>Türkisch</th>
            <th />
        </tr>
        </thead>
        <tbody>

        @foreach($translations as $translation)

            <tr>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'show'], $translation->key) }}">
                        {{$translation->key}}
                    </a>
                </td>
                <td title="{{ strip_tags($translation->de) }}">{{ Illuminate\Support\Str::limit($translation->de, 50) }}</td>
                <td title="{{ strip_tags($translation->en) }}">{{ Illuminate\Support\Str::limit(strip_tags($translation->en), 50) }}</td>
                <td title="{{ strip_tags($translation->fr) }}">{{ Illuminate\Support\Str::limit(strip_tags($translation->fr), 50) }}</td>
                <td title="{{ strip_tags($translation->tr) }}">{{ Illuminate\Support\Str::limit(strip_tags($translation->tr), 50) }}</td>
                <td>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'show'], $translation->key) }}"
                           title="Übersetzung anzeigen">
                            <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
                        </a>

                        <a href="{{ URL::action([App\Http\Controllers\TranslationController::class, 'edit'], $translation->key) }}"
                       title="Übersetzung bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>

                    </span>
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

@endsection