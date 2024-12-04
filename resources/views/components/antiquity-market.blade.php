<x-form.text :$entity :label='"Id"' dbField='id' :$action :create='false' :edit='false'/>
<x-form.text :$entity dbField='antiquity_market' :label='"Auction House"' :placeholder='""' :$action />
<x-history :$entity :$action />