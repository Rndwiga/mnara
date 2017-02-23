<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mnara Navigation Menu
    |--------------------------------------------------------------------------
    |
    | The navigation links that run across the top of the Mnara master 
    | layout? That's these options right here. Add as many of them as you
    | want to have appear.
    |
    */ 
    'navigation' => [ 
        [
            'group' => 'Users',
            'class' => 'fa fa-user fa-lg',
            'links' => [
                [
                  'title' => 'Add User',
                  'class' => 'fa fa-fw fa-plus',
                  'route' => 'mnara.user.create'
                ],
                [
                  'title' => 'List Users',
                  'class' => 'fa fa-fw fa-th-list',
                  'route' => 'mnara.user.index'
                ],

                'separator',
                
                [
                  'title' => 'User Matrix',
                  'class' => 'fa fa-fw fa-table',
                  'route' => 'mnara.user.matrix'
                ]
            ]
        ],

        [
            'group' => 'Roles',
            'class' => 'fa fa-users fa-lg',
            'links' => [
                [
                  'title' => 'Add Role',
                  'class' => 'fa fa-fw fa-plus',
                  'route' => 'mnara.role.create'
                ],
                [
                  'title' => 'List Roles',
                  'class' => 'fa fa-fw fa-th-list',
                  'route' => 'mnara.role.index'
                ],

                  'separator',

                [
                  'title' => 'Role Matrix',
                  'class' => 'fa fa-fw fa-table',
                  'route' => 'mnara.role.matrix'
                ]
            ]
        ],

        [
            'group' => 'Permissions',
            'class' => 'fa fa-key fa-lg',
            'links' => [
                [
                  'title' => 'Add Permission',
                  'class' => 'fa fa-fw fa-plus',
                  'route' => 'mnara.permission.create'
                ],
                [
                  'title' => 'List Permissions',
                  'class' => 'fa fa-fw fa-th-list',
                  'route' => 'mnara.permission.index'
                ],
            ]
        ],
        [
            'group' => 'Authentication',
            'class' => 'fa fa-plug fa-lg',
            'links' => [
                [
                    'title' => 'Set Authentication',
                    'class' => 'fa fa-ticket fa-plus',
                    'route' => 'mnara.authenticator.index'
                ],
            ]
        ]
    ],
];