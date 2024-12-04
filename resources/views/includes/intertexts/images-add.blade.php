<div class="input-form input-image">
    <h4>
        Image
        <span class="label label-default">{{ $counter }}</span>
    </h4>
    <hr>
    <div class="form-horizontal">
        <div class="form-group">
             {!! Form::file("images[]") !!}
            <div class="input-group">
            {!! Form::label("licence_for_image", "", array("class" => "input-group-addon")) !!}
            {!! Form::text("licence_for_image[]", "", array("class" => "form-control", "placeholder" => "licence for image")) !!}
            </div>
        </div>
    </div>
    <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Remove Image</div>
    <hr>
</div>
