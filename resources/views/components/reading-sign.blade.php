<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"reading_sign"' :label='"Reading Sign"' :placeholder='""' :$action />
<x-history :$entity :$action />