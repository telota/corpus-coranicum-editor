<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"provenance"' :label='"Provenance"' :placeholder='""' :$action />
<x-history :$entity :$action />