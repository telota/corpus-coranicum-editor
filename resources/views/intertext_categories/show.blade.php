@extends("layouts.master")

@section("title")
    <h1>
        {{ $category->category_name  }}
        <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryController::class, 'edit'], $category->id) }}">
            <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
        </a>
    </h1>
@endsection
@section("content")

{{--    @include("includes.metadata", array("record" => $category))--}}
<h3>Metadata</h3>
    <ul class="list-group">
        <li class="list-group-item">
            <span class="label label-default">ID</span>
            {!! $category->id !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Category Name</span>
            {!! $category->category_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Classification</span>
            {!! $category->classification !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Super Category ID</span>
            {!! $category->supercategory !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Super Category</span>
            {!! \App\Models\Intertexts\IntertextCategory::find($category->supercategory)->category_name !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created By</span>
            {!! $category->created_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated By</span>
            {!! $category->updated_by !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Created At</span>
            {!! $category->created_at !!}
        </li>
        <li class="list-group-item">
            <span class="label label-default">Updated At</span>
            {!! $category->updated_at !!}
        </li>
    </ul>

<h3>
    Information Text
    <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'create'], $category->id) }}"
       title="Neue Entry Translation hinzufügen">
        <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
    </a>
</h3>
<ul class="list-group">
    <li class="list-group-item">
        <span class="label label-default">Information Text Authors</span>
        {!! \App\Models\Intertexts\IntertextCategory::getInfoAuthorsImplode($category) !!}
    </li>
    <li class="list-group-item">
        <span class="label label-default">Information Text</span>
        {!! $category->source_information_text !!}
    </li>
    <h5>Translations:</h5>
    @foreach($category->infoTranslations as $info)
        <?php $language = $info->language->translation_language?>
        <li class="list-group-item">
            <span class="label label-default">{{ ucfirst($language) }} Information Text</span>
            {!! $info->information_translation !!}
            <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'show'], $info->id) }}"
               title="Entry anzeigen">
                <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
            </a>
            <a href="{{ URL::action([App\Http\Controllers\IntertextCategoryInformationTranslationController::class, 'edit'], $info->id) }}">
                <span class="glyphicon glyphicon-pencil glyphicon-hover"></span>
            </a>
        </li>
    @endforeach
</ul>

    <hr>
    <?php $onlineString = array(2 => "ja", 1 => "Webtauglich (ohne Bild)", 0 => "nein");
    ?>
    <table class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>webtauglich</th>
        </tr>
        </thead>

        <tbody>
            @foreach($category->intertexts as $intertext)
                <tr>
                <td>
                    {{ $intertext->id }}
                </td>
                <td>
                    <a href="{{ URL::action([App\Http\Controllers\IntertextController::class, 'show'], $intertext->id) }}">
                    {{ strip_tags($intertext->getNameString()) }}
                    </a>
                </td>
                <td>{{ $onlineString[$intertext->is_online] }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

@endsection
