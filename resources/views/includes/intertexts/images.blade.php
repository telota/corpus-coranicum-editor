<div class="panel panel-default" id="panel-images">

    <div class="panel-heading">
        <span class="panel-title">Intertext Images</span>
    </div>
    <div class="panel-body">

        @foreach($intertext->images as $index => $image)

            <div class="input-form input-image">
                <h4>
                    Bild
                    <span class="label label-default">{{ ($index + 1) }} </span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    {!! Form::text("existing_images[]", $image->id, array("class" => "hide")) !!}

                    <a href="{{ Config::get("constants.digilib.scaler") . $image->image_link . "&mo=ascale,1" }}" target="_blank">
                        <img src="{{ Config::get("constants.digilib.scaler") . $image->image_link . "&dw=800" }}">
                    </a>

                    <div class="input-group">
                        {!! Form::label("licence_for_image_label", "licence_for_image", array("class" => "input-group-addon")) !!}
                        {!! Form::text("licence_for_image[]", $image->licence_for_image, array("class" => "form-control", "placeholder" => "licence for image")) !!}
                    </div>
                </div>
                <hr>
                <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Remove Image</div>
                <hr>
            </div>

        @endforeach

        <div class="btn btn-primary" id="add-image" route="intertexts"><span class="glyphicon glyphicon-plus"></span> Add Image</div>
    </div>
</div>
