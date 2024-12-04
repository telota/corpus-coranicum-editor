<div class="panel panel-default">
    <div class="panel-heading">
        <label for="{{$name}}" class="panel-title">
            {{ $label }}
        </label>
    </div>
    <div class="panel-body">
        <div class="input-group">
            <select class="form-control" name="{{$name}}" id="{{$name}}">
                @foreach($options as $key=>$display)
                    <option value='{{$key}}'
                            @if($value == $key)
                                selected='selected'
                            @endif
                    >
                        {{$display}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>