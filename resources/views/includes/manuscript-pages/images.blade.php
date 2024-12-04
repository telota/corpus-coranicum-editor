{{-- @if (!$manuscriptPage->id) --}}
<div class="panel panel-default" id="panel-textstelle">
    <div class="panel-heading">Quran Texts</div>
    <div class="panel-body">

        @foreach ($manuscriptPage->mappings as $index => $textstelle)
            <div class="input-form input__textstelle">
                <h4>
                    Quran Text
                    <span class="label label-default">{{ $index + 1 }}</span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    <div class="form-group">
                        {{-- Iterate from sura 1 to 114 (max sura) --}}
                        {!! Form::label('sure_s', 'Sure (Start)') !!}
                        {!! Form::select(
                            'sure_s[]',
                            array_combine(range(1, 114), range(1, 114)),
                            ltrim($textstelle['sura_start'], '0'),
                            ['class' => 'sureselect', 'id' => 'sure_s'],
                        ) !!}

                        {{-- Iterate from verse counter 0 (min verse) to 286 (max max of all verses) --}}
                        {!! Form::label('vers_s', 'Vers (Start)') !!}
                        {!! Form::select(
                            'vers_s[]',
                            array_combine(range(0, 286), range(0, 286)),
                            ltrim($textstelle['verse_start'], '0'),
                            ['class' => 'versselect', 'id' => 'vers_s'],
                        ) !!}

                        {{-- Iterate from word counter 0 (min word) to 129 (max word) --}}
                        {!! Form::label('wort_s', 'Word (Start)') !!}
                        {!! Form::select(
                            'wort_s[]',
                            array_combine(range(0, 128), range(0, 128)),
                            ltrim($textstelle['word_start'], '0'),
                            ['class' => 'wortselect', 'id' => 'wort_s'],
                        ) !!}
                        <span class="arab arab-word"></span>
                    </div>
                    <div class="form-group">
                        {!! Form::label('sure_e', 'Sure (End)') !!}
                        {!! Form::select('sure_e[]', array_combine(range(1, 114), range(1, 114)), ltrim($textstelle['sura_end'], '0'), [
                            'class' => 'sureselect',
                            'id' => 'sure_e',
                        ]) !!}

                        {!! Form::label('vers_e', 'Vers (End)') !!}
                        {!! Form::select('vers_e[]', array_combine(range(0, 286), range(0, 286)), ltrim($textstelle['verse_end'], '0'), [
                            'class' => 'versselect',
                            'id' => 'vers_e',
                        ]) !!}

                        {!! Form::label('wort_e', 'Word (End)') !!}
                        {!! Form::select('wort_e[]', array_combine(range(0, 128), range(0, 128)), ltrim($textstelle['word_end'], '0'), [
                            'class' => 'wortselect',
                            'id' => 'wort_e',
                        ]) !!}
                        <span class="arab arab-word"></span>

                    </div>
                </div>
                <div class="btn btn-danger remove-textstelle"><span class="glyphicon glyphicon-remove"></span> Remove
                    Quran Text</div>
                <hr>
            </div>
        @endforeach

        <div class="btn btn-primary" id="add-textstelle"><span class="glyphicon glyphicon-plus"></span> Add Quran Text
        </div>
    </div>
</div>
{{-- @endif --}}

<div class="panel panel-default" id="panel-images">
    <div class="panel-heading">Manuscript Page Images</div>
    <div class="panel-body">
        @foreach (collect($manuscriptPage->images)->sortBy('sort') as $image)
            <div class="input-form input-image">
                <h4>
                    Image
                    <span class="label label-default">{{ $image->sort }} </span>
                </h4>
                <hr>
                <div class="form-horizontal">
                    {!! Form::text('existing_images[]', $image->id, ['class' => 'hide']) !!}

                    <a href="{{ $image->fullPath }}" target="_blank">
                        <img src="{{ $image->scalerPath }}">
                    </a>

                    <div class="input-group">
                        {!! Form::label('bildlinknachweis_label', 'Credit Line Image', ['class' => 'input-group-addon']) !!}
                        {!! Form::text('bildlinknachweis[]', $image->credit_line_image, [
                            'class' => 'form-control',
                            'placeholder' => 'Credit Line Image',
                        ]) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label('bildlink_extern_label', 'Image Link (extern)', ['class' => 'input-group-addon']) !!}
                        {!! Form::text('bildlink_extern[]', $image->image_link_external, [
                            'class' => 'form-control',
                            'placeholder' => 'Image Link (extern)',
                        ]) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label('sort', 'Sort', ['class' => 'input-group-addon']) !!}
                        {!! Form::number('sort[]', $image->sort, ['class' => 'form-control', 'placeholder' => 'Sort']) !!}
                    </div>

                    <div class="input-group">
                        {!! Form::label('bildlink_webtauglich_label', 'Online', ['class' => 'input-group-addon']) !!}
                        {!! Form::select('bildlink_webtauglich[]', [1 => 'yes', 0 => 'no'], $image->is_online) !!}
                    </div>

                </div>
                <hr>
                <div class="btn btn-danger remove-image"><span class="glyphicon glyphicon-remove"></span> Remove Image
                </div>
                <hr>
            </div>
        @endforeach

        <div class="btn btn-primary" id="add-image" route="manuscript-pages"><span
                class="glyphicon glyphicon-plus"></span> Add Image</div>
    </div>
</div>
