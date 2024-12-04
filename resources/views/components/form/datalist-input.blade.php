@if($action == \App\Enums\FormAction::Show && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {{ array_key_exists( $value, $options->toArray()) ? "$value ($options[$value]) " : "" }}
        </td>
    </tr>
@elseif(($action == \App\Enums\FormAction::Create && $create) || ($action == \App\Enums\FormAction::Edit && $edit))
    @php($flipped=$options->flip())
    <div class="panel panel-default">
        <div class="panel-heading">
            <label for="{{$id}}" class="panel-title">
                {{ $label }}
            </label>
        </div>
        <div class="panel-body">
            <div class="input-group">
                <input class="form-control" list="{{$id . "_datalist"}}" name="{{'datalist_' . $name}}" id="{{$id}}"
                       value='{{$options->has($value) ? $options[$value] : "" }}'
                >
                <datalist id='{{$id . "_datalist"}}'>
                    @foreach($options as $key=>$display)
                        <option value='{{$display}}'>
                    @endforeach
                </datalist>
                <input  type="hidden" name="{{$name}}" id="{{$id . "_true_input"}}" value='{{$value}}'>
            </div>
        </div>
    </div>
    <script>
      values = @json($flipped);
        console.log(values);
        document.getElementById('{{$id}}').addEventListener('input', function(e){
          if(values.hasOwnProperty(e.target.value)){
            document.getElementById('{{$id . "_true_input"}}').value = values[e.target.value];
          }
        });


    </script>
@endif