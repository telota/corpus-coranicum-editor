

    {!! Form::model($intertextCategory, array("action" => $action)) !!}

    <div class="form-group">
        <label for="name">Name</label>
        {!! Form::text("category_name", $intertextCategory->category_name, array("class" => "form-control")) !!}
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Super Category</div>
        <div class="panel-body">
            <div class="input-group">
                {!! Form::select('supercategory',
                \App\Models\Intertexts\IntertextCategory::getAllSuperCategoriesSelect(),
                 empty($intertextCategory->supercategory) ? 0 : $intertextCategory->supercategory) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="classification">Classification</label>
        {!! Form::text("classification", $intertextCategory->classification, array("class" => "form-control")) !!}
    </div>

    @if(isset($intertextCategory->id))
        @include("intertext_categories.checkboxes.information-authors")
    @endif

    <div class="form-group">
        <label for="source_description">Source Information Text</label>
        <span class="btn btn-primary btn-xs summernote-activator" summernote-target="#{{ str_replace(" ", "_", "source_information_text") }}">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit in Editor
        </span>
        {!! Form::textarea("source_information_text", $intertextCategory->source_information_text, array("class" => "form-control")) !!}
    </div>

    {!! Form::Button('<i class="glyphicon glyphicon-save"></i> Speichern',
    array("class" => "btn btn-primary", "type" => "submit")) !!}

    {!! Form::close() !!}

