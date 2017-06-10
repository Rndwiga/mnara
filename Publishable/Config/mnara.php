<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Overview of config
    |--------------------------------------------------------------------------
    |
    | This config might look a little long, but it allows a lot of flexibility.
    | You can choose your own views for each page, and the permissions (if
    | any at all) required to access all the different sections.
    |
    |--------------------------------------------------------------------------
    | Title for this user admin section
    |--------------------------------------------------------------------------
    |
    | The name of your site (or whatever) you want displayed on the header.
    |
    */
    'site_title' => 'Mnara',
    'site_url' => 'https://github.com/Rndwiga/mnara',


    /*
    |--------------------------------------------------------------------------
    | Default model to use
    |--------------------------------------------------------------------------
    |
    | By default, mnara uses its own internal User model. If you have a
    | User model you would rather use, provide the name here.
    |
    | To provide additional Validation rules to the default Update or Store
    | form request, place them under the rules heading. By default, the
    | rules for password, password confirmation and username are part
    | of the request already. But you can override them with yours.
    |
    */
    'user' => [
        'model' => \Tyondo\Mnara\Models\User::class,
        'rules' => [
            'update' => [],
            'store'  => [],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Mnara 2fa Authenticator
    |--------------------------------------------------------------------------
    |
    |
    */

    'options' => [
        'name' => 'Tyondo Enterprise',
        'email' => 'packages@tyondo.com',
        'file' => 'google2fasecret.key',
        'keySize' => 32,
        'keyPrefix' => '',
    ],

    /*
    |--------------------------------------------------------------------
    | Theme: Gentella
    |----------------------------------------------------------------------------------
    | The default theme used by Mnara is derived from  gentella a Free Bootstrap 3 Admin Template from
    |    https://colorlib.com/polygon/gentelella/index.html
    | You can enhance the look and feel of the application by developing themes based on
    | caffeinated/themes : https://github.com/caffeinated/themes
    */
    'use_theme' => false,


    /*
    |--------------------------------------------------------------------------
    | Mnara Permissions
    |--------------------------------------------------------------------------
    |
    | Mnara comes ready to go with pre-defined permissions to access all
    | the different areas. Feel free to change them to match your needs, if
    | you wish. Can be a permission slug from shinobi's tables, or even a
    | boolean true/false to globally enable/disable permission. However,
    | the permissions in mnara will return "false" for security
    | if nothing else is supplied in a config file.
    |
    */
    'acl' => [
        'user' => [
            'index'         => 'show.user.index',
            'create'        => 'create.user',
            'show'          => 'show.user',
            'edit'          => 'edit.user',
            'destroy'       => 'destroy.user',
            'role'          => 'sync.user.roles',
            'usermatrix'    => 'sync.user.roles',
            'viewmatrix'    => 'show.user.index',
            'search'        => 'search.user',
            'profile'       => 'show.user.profile'
        ],

        'role' => [
            'index'         => 'show.role.index',
            'create'        => 'create.role',
            'show'          => 'show.role',
            'edit'          => 'edit.role',
            'destroy'       => 'destroy.role',
            'users'         => 'sync.role.users',
            'viewmatrix'    => 'show.role.index',
            'rolematrix'    => 'sync.role.permissions',
            'permissions'   => 'sync.role.permissions',
            'search'        => 'search.role'
        ],

        'permission' => [
            'index'         => 'show.permission.index',
            'create'        => 'create.permission',
            'show'          => 'show.permission',
            'edit'          => 'edit.permission',
            'destroy'       => 'destroy.permission',
            'role'          => 'sync.permission.roles',
            'search'        => 'search.permission'
        ],

        'mnara' => [
            'index'         => 'show.mnara.index'
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Mnara Views
    |--------------------------------------------------------------------------
    |
    | Mnara comes pre-equipped with views that will work out of the box.
    | However, you are free to define you own views here instead.
    |
    */
    'views' => [
        'layouts' => [
            'master'        => 'mnara::admin.layouts.app',
            'flash'         => 'mnara::admin.partials.flash',
            'modal'         => 'mnara::admin.partials.modal',
            'search'        => 'mnara::admin.partials.search',
            'dashboard'     => 'mnara::admin.mnara.index',
            'adminlinks'    => 'mnara::admin.mnara.links',
            'unauthorized'  => 'mnara::admin.partials.unauthorized',
            'includes' => [
                'left' =>  'mnara::admin.layouts.includes.left-navigation',
                'top' =>  'mnara::admin.layouts.includes.top-navigation',
                'footer' =>  'mnara::admin.layouts.includes.footer'
            ],
        ],

        'users' => [
            'index'     => 'mnara::admin.user.index',
            'create'    => 'mnara::admin.user.create',
            'show'      => 'mnara::admin.user.edit',
            'edit'      => 'mnara::admin.user.edit',
            'role'      => 'mnara::admin.user.role',
            'usermatrix'=> 'mnara::admin.user.matrix',
            'profile'   => 'mnara::user.profile',
            'account-activity'   => 'mnara::user.account-activity',
        ],

        'roles' => [
            'index'     => 'mnara::admin.role.index',
            'create'    => 'mnara::admin.partials.create',
            'show'      => 'mnara::admin.partials.edit',
            'edit'      => 'mnara::admin.partials.edit',
            'user'      => 'mnara::admin.role.user',
            'rolematrix'=> 'mnara::admin.role.matrix',
            'permission'=> 'mnara::admin.role.permission'
        ],

        'permissions' => [
            'index'     => 'mnara::admin.permission.index',
            'create'    => 'mnara::admin.partials.create',
            'show'      => 'mnara::admin.partials.edit',
            'edit'      => 'mnara::admin.partials.edit',
            'role'      => 'mnara::admin.permission.role'
        ],
        'auth' => [
            'index'     => 'mnara::admin.auth.login',
            'register'  => 'mnara::admin.auth.register',
            'show'      => 'mnara::admin.authenticator.edit',
            'edit'      => 'mnara::admin.authenticator.edit',
            'role'      => 'mnara::admin.authenticator.role'
        ],
        'authenticator' => [
            'index'     => 'mnara::admin.authenticator.index',
            'create'    => 'mnara::admin.authenticator.create',
            'show'      => 'mnara::admin.authenticator.edit',
            'edit'      => 'mnara::admin.authenticator.edit',
            'role'      => 'mnara::admin.authenticator.role'
        ],
        'shared'=>[
            'google-analytics' => 'mnara::admin.shared.GoogleAnalytics'
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Mnara dashboard
    |--------------------------------------------------------------------------
    |
    | This is the main index page of the Mnara. Everyone seems to like
    | the term dashboard, so we stuck with that. However, you are free to
    | add your own links to different admin sections of your application
    | if you wish. Make sure your route is a named route for proper
    | linkage.
    |
    */
    'dashboard' => [
        'users' => [
            'name'  => "Users",
            'route' => 'mnara.user.index',
            'icon'  => 'fa fa-user fa-5x',
            'colour'=> 'primary'
        ],

        'roles' => [
            'name'  => "Roles",
            'route' => 'mnara.role.index',
            'icon'  => 'fa fa-users fa-5x',
            'colour'=> 'info'
        ],

        'permissions' => [
            'name'  => "Permissions",
            'route' => 'mnara.permission.index',
            'icon'  => 'fa fa-5x fa-key',
            'colour'=> 'success'
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Mnara pagination
    |--------------------------------------------------------------------------
    |
    | The default is to show 15 items per page. Change this to whatever
    | value you prefer. Note, doesn't apply to matrices.
    |
    */
    'pagination' => [
        'users'         => '15',
        'roles'         => '15',
        'permissions'   => '15',
    ],


    /*
    |--------------------------------------------------------------------------
    | Route Options
    |--------------------------------------------------------------------------
    | Prefix :
    |-------------------------
    |
    | If you want to prefix all your mnara routes, enter the prefix here.
    | https://laravel.com/docs/5.3/routing#route-group-prefixes for info.
    |
    | i.e 'route_prefix' => 'admin' will change your urls to look
    | like 'http://<yoursite>/admin/mnara/user' instead of
    | 'http://<yoursite>/mnara/user'. Default is none.
    |
    |-------------------------
    | Middleware :
    |-------------------------
    | An array of middlewares you wish to pass in to the group. Laravel 5.3 and 5.4
    | by default requires that the "web" middleware be use for any routes
    | that need access to session, csrf protection and cookies
    |
    |-------------------------
    | As :
    |-------------------------
    | If you want to use something other than "mnara" in your named routes
    | you can specify it here.
    |
    */
    'route' => [
        'prefix'    => '',
        'as'        => 'mnara.',
        'middleware'=> ['web', 'auth']
    ]

];