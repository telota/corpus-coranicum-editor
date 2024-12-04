<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"person"' :label='"Attributed To"' :placeholder='""' :$action />
<x-history :$entity :$action />