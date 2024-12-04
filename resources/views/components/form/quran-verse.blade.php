@if($action->value == 'show' && $show)
    <tr>
        <td class="labelColumn">
            Quran Verse
        </td>
        <td>
            {{ "$sura:$verse"}}
        </td>
    </tr>
@elseif(($action->value == 'create' && $create) || ($action->value == 'edit' && $edit))
    <div class="panel panel-default" id='reading-variant-verse'>
        <div class="panel-heading">
            <div for="verse" class="panel-title">
                Quran Verse
            </div>
        </div>
        <div class="panel-body">
            <div class="input-group">
                <label>Sura</label>
                <input class="small-input" name="sure" id="sura" type="text" maxlength='3'
                       value="{{old('sure', $sura)}}"
                >
                <label>Verse</label>
                <input class="small-input" name="vers" id="verse" type="text" maxlength='3'
                       value="{{old('vers', $verse)}}"
                >
            </div>
        </div>
    </div>
    <script>
      document.getElementById('sura').focus();
    </script>
@endif