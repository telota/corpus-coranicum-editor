@extends("layouts.master")

@section("title")
    <h1>
        {{ $language->translation_language  }}
        <a href="{{ URL::action([App\Http\Controllers\CCTranslationLanguageController::class, 'edit'], $language->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection

@section("content")

    @include("includes.metadata", array("record" => $language))

    <h1 class="bg-primary">Intertext Module</h1>

    <h2>Intertext Translations</h2>
    <hr>
    <h3>Original Reference Text Translations</h3>

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
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Original Reference Text Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextOriginalTranslationController::class, 'edit'], $translation->id) }}"
                           title="Original Reference Text bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
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
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Entry Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextEntryTranslationController::class, 'edit'], $translation->id) }}"
                           title="Entry bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
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
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceInformationTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Source Information Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceInformationTranslationController::class, 'edit'], $translation->id) }}"
                           title="Source Information bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
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
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorInformationTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Source Author Information Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextSourceAuthorInformationTranslationController::class, 'edit'], $translation->id) }}"
                           title="Source Author Information bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
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
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                      title="Category Information Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'edit'], $translation->id) }}"
                           title="Category Information bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>


    <h1 class="bg-primary">Manuscript Module</h1>

    <h2>Colophon Translations</h2>
    <hr>

    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Manuscript</th>
            <th>Translator</th>
        </tr>
        </thead>

        <tbody>
        @foreach($language->colophonTextTranslations as $translation)
            <tr>
                <td>
                    {{ $translation->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\ManuscriptNewController::class, 'show'], $translation->manuscript_id) }}">
                        {{ strip_tags($translation->manuscript->getNameString()) }}
                    </a>
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\CCAuthorController::class, 'show'], $translation->translator_id) }}">
                        {{ strip_tags($translation->translator->author_name) }}
                    </a>
                    <span class="pull-right">
                        <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'show'], $translation->id) }}">
                                <span class="glyphicon glyphicon-eye-open glyphicon-hover"
                                title="Colophon Translation anzeigen"></span>
                        </a>
                        <a href="{{ URL::action([App\Http\Controllers\ManuscriptColophonTranslationController::class, 'edit'], $translation->id) }}"
                                                   title="Colophon Translation bearbeiten">
                            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
                        </a>
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>


@endsection
