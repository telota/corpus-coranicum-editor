<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity :dbField='"diacritic"' :label='"Diacritic"' :placeholder='"diacritic"' :$action />
<x-history :$entity :$action />