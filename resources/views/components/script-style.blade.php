<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"style"' :label='"Script Style"' :placeholder='""' :$action />
<x-history :$entity :$action />