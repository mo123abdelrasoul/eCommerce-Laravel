<?php

return [
    'default' => [
        'policy' => 'weight',
        'method' => 'standard',
        'volumetric_divisor' => 5000,
    ],

    'carriers' => [
        'standard' => [
            'name' => 'Standard Delivery',
            'delivery_time' => 7,
            'description' => 'Delivery within 7 business days',
        ],
        'express' => [
            'name' => 'Express Delivery',
            'delivery_time' => 3,
            'description' => 'Delivery within 3 business days',
        ],
    ],
    'weight_classes' => [
        'light' => 1,
        'medium' => 3,
        'heavy' => 5,
    ]
];
