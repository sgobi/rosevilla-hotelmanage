<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Heritage Room Direct Configuration
    |--------------------------------------------------------------------------
    |
    | Single configuration file for Heritage Room details.
    |
    */
    'bed_type' => env('HERITAGE_ROOM_BED_TYPE', 'Queen bed + daybed'),
    'capacity' => (int) env('HERITAGE_ROOM_CAPACITY', 3), // up to 3 guests
    'capacity_label' => env('HERITAGE_ROOM_CAPACITY_LABEL', 'Up to 3 Guests'),
    'description' => env(
        'HERITAGE_ROOM_DESCRIPTION',
        'Soak in the calm Uduvil retreat, featuring a comfortable Queen bed + daybed, warm wooden finishes, and a peaceful sit-out that opens directly onto the garden'
    ),
    'amenities' => [
        'Ensuite rain shower',
        'Private verandah with courtyard view',
        'Breakfast with heritage recipes',
    ],

];

