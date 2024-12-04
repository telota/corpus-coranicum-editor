<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity label="Wort" dbField='wort' :$action />
<x-form.text :$entity label="Wurzel" dbField='wurzel' :$action />
<x-form.wysiwyg :$entity dbField='literatur' label='Literatur' :$action />
<x-form.wysiwyg :$entity dbField='anmerkungen' label='Anmerkungen' :$action />
<x-form.text :$entity label="Bearbeiter" dbField='bearbeiter' :$action />
