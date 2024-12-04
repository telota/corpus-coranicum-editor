@extends("layouts.master")

@section("title")
    <h1>
        {{ $language->translation_language  }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextTranslationLanguageController::class, 'edit'], $language->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $language))
<h2>Intertext Translations</h2>
    <hr>
    <h3>Original Translations</h3>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Intertext</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
            @foreach($language->intertextOriginalTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $translation->intertext_id) }}">
                        {{ strip_tags($translation->intertext->getNameString()) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <h3>Entry Translations</h3>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Intertext</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
        @foreach($language->intertextEntryTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $translation->intertext_id) }}">
                        {{ strip_tags($translation->intertext->getNameString()) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <hr>
    <h2>Source Translations</h2>
    <hr>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
        @foreach($language->sourceInformationTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceController::class, 'show'], $translation->source_id) }}">
                        {{ strip_tags($translation->source->source_name) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <hr>
    <h2>Source Author Translations</h2>
    <hr>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
        @foreach($language->sourceAuthorInformationTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorController::class, 'show'], $translation->source_author_id) }}">
                        {{ strip_tags($translation->sourceAuthor->author_name) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <hr>
    <h2>Category Translations</h2>
    <hr>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
        @foreach($language->categoryInformationTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'show'], $translation->category_id) }}">
                        {{ strip_tags($translation->category->category_name) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
