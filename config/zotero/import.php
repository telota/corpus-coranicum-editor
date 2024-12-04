<?php
return  [
    'url'           => "https://api.zotero.org/groups/265673/items/", # Link to Zotero item
    'zotero_limit'      => 100, # zotero delivers 100 entrys at the moment
    'zotero_min'        => 1, # zotero limit
    'additional-informations' => [
        'series',
        'volume',
        'edition',
        'place',
        'publisher',
        'date',
    ],
];
