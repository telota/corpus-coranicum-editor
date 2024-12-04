<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"titel"' label='Titel' :placeholder='""' :$action />
<x-form.text :$entity :dbField='"ort"' label='Ort' :placeholder='""' :$action />
<x-form.date-time :datetime='$entity->datum_start' dbField='datum_start' label='Start' :$action />
<x-form.date-time :datetime='$entity->datum_ende' dbField='datum_ende' label='End' :$action />
<x-form.wysiwyg :$entity :dbField='"beschreibung"' :label='"Beschreibung"' :placeholder='""' :$action />
