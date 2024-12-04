<?php

return [
    'digilib' => [
        'base' => 'https://digilib.bbaw.de/digilib/',
        'scaler_path' => "servlet/Scaler?fn=",
        'full_image' => "greyskin/diginew.jsp?fn=",
        'scaler' => 'https://digilib.bbaw.de/digilib/servlet/Scaler?fn=' . env('DIGILIB_DIR'),
        'full' => 'https://digilib.bbaw.de/digilib/greyskin/diginew.jsp?fn=/' . env('DIGILIB_DIR'),
        'width' => '&dw=80',
        'iiif' => [
            'scaler' => 'https://digilib.bbaw.de/digilib/servlet/Scaler/IIIF' . env('DIGILIB_DIR') . '!',
            'size' => [
                'full' => '/full/full/0/default.jpg',
                'thumbnail' => '/full/80,100/0/default',
                'modal' => '/full/500,/0/default.jpg',
                'crop' => '/pct:{x},{y},{width},{height}/full/0/default.jpg'
            ],
            'fallback' => [
                'no_rights' => 'kein-manuskript.jpg'
            ]
        ],
    ],
    'local_digilib_url'=> '/digital_library/',
    'local_file_directory' => 'local_file/',
    'dev_file_directory' => 'testing_directory/',
];

