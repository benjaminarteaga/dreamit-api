<?php

return [
    'enabled' => true,

    // Add values to this array to hide certain sections from your views.
    // For all valid sections see the class \Styde\Enlighten\Section
    'hide' => [
        // 'queries',
        // 'html',
        // 'blade',
        // 'route_parameters',
        // 'request_input',
        // 'request_headers',
        // 'response_headers',
        // 'session',
        // 'exception',
    ],

    // Default directory to export the documentation.
    'docs_base_dir' => 'public/docs',
    // Default base URL for exported the documentation.
    'docs_base_url' => '/docs',

    // Display / hide quick access links to open your IDE from the UI
    'developer_mode' => false,
    'editor' => 'vscode', // phpstorm, vscode or sublime

    'tests' => [
        // Add regular expressions to skip certain test classes and test methods.
        // i.e. Tests\Unit\* will ignore all the tests in the Tests\Unit\ suite,
        // validates_* will ignore all the tests that start with "validates_".
        'ignore' => [],
    ],

    // You can use the arrays belows to hide or obfuscate certain parameters from the
    // HTTP requests including headers, input, query parameter, session data, etc.
    'request' => [
        'headers' => [
            'hide' => [],
            'overwrite' => [],
        ],
        'query' => [
            'hide' => [],
            'overwrite' => [],
        ],
        'input' => [
            'hide' => [],
            'overwrite' => [],
        ],
    ],

    'response' => [
        'headers' => [
            'hide' => [],
            'overwrite' => [],
        ],
        'body' => [
            'hide' => [],
            'overwrite' => [],
        ]
    ],

    'session' => [
        'hide' => [],
        'overwrite' => [],
    ],

    // Configure a default view for the panel. Options: features, modules and endpoints.
    'area_view' => 'features',

    // Customise the name and view template of each area that will be shown in the panel.
    // By default, each area slug will represent a "test suite" in the tests directory.
    // Each area can have a different view style, ex: features, modules or endpoints.
    'areas' => [
        [
            'slug' => 'api',
            'name' => 'API',
            'view' => 'endpoints',
        ],
        [
            'slug' => 'feature',
            'name' => 'Features',
            'view' => 'modules',
        ],
        [
            'slug' => 'unit',
            'name' => 'Unit',
            'view' => 'features',
        ],
    ],

    // If you want to use "modules" or "endpoints" as the area view,
    // you will need to configure the modules adding their names
    // and patterns to match the test classes and/or routes.
    'modules' => [
        [
            'name' => 'Users',
            'classes' => ['*User*'],
            'routes' => ['users/*'],
        ],
        [
            'name' => 'Persons',
            'classes' => ['*Person*'],
            'routes' => ['persons/*'],
        ],
        [
            'name' => 'Buildings',
            'classes' => ['*Building*'],
            'routes' => ['buildings/*'],
        ],
        [
            'name' => 'Accesses',
            'classes' => ['*Access*'],
            'routes' => ['accesses/*'],
        ],
        [
            'name' => 'Blocks',
            'classes' => ['*Block*'],
            'routes' => ['blocks/*'],
        ],
        [
            'name' => 'Other Modules',
            'classes' => ['*'],
        ],
    ]
];
