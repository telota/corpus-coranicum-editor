@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            {{ $label }}
        </td>
        <td>
            {!! $entity->$dbField ?? "" !!}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default">
        <div class="panel-heading">
            <label for="{{$entity->$dbField}}" class="panel-title">
                {{ $label }}
            </label>
        </div>

        <div class="panel-body">
            <div class="form-group">
      <textarea name='{{$dbField}}'
                id='{{$dbField}}' placeholder='Enter html here...' style='width: 100%; min-height: 400px'
                onkeyup='updateHtmlView(this)'
      >{{$entity->$dbField}}</textarea>
                <div><h4><b>Rendered Html:</b></h4></div>
                <div id='html-content-{{$dbField}}' style='border: 1px solid; min-height: 40px; padding: 2px'>
                    {!!$entity->$dbField!!}
                </div>
            </div>
        </div>
    </div>
    <script>function updateHtmlView(event) {
        var myDiv = document.getElementById("html-content-" + event.id);
        myDiv.innerHTML = event.value;
      }
    </script>
@endif