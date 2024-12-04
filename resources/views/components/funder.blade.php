<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"funder"' :label='"Funder"' :placeholder='"funder"' :$action />
<x-history :$entity :$action />