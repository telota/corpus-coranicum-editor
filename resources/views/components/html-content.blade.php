<x-form.text :$entity :label='"Label"' dbField='label' :$action :edit='false'/>
@if($action->value =="edit")
    <input  type="hidden" name="label" value='{{$entity->label}}'>
@endif
<x-form.pure-html :$entity label="DE" dbField='de' :$action />
<x-form.pure-html :$entity label="EN" dbField='en' :$action />
<x-form.pure-html :$entity label="FR" dbField='fr' :$action />
<x-history :$entity :$action />
