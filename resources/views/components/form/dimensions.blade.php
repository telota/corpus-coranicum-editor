<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">{{ $title }}</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <label
                            class='input-group-addon'
                            for='{{$nameWidth}}'
                    >
                        {{$labelWidth}}
                    </label>
                    <input
                            class='form-control'
                            type='number'
                            name='{{$nameWidth}}'
                            id='{{$nameWidth}}'
                            value='{{old($nameWidth, $width)}}'
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group">
                    <label
                            class='input-group-addon'
                            for='{{$nameHeight}}'
                    >
                        {{$labelHeight}}
                    </label>
                    <input
                            class='form-control'
                            type='number'
                            name='{{$nameHeight}}'
                            id='{{$nameHeight}}'
                            value='{{old($nameHeight, $height)}}'
                    >
                </div>
            </div>
        </div>
    </div>
</div>
