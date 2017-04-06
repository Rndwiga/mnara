<?php

Route::group( [
    'as' => 'mnara.',
], function () {
    event('mnara.routing', app('router'));
    $namespacePrefix = '\\'.'Tyondo\\Mnara\\Http\\Controllers'.'\\';

    Route::get('/mnara/authenticator', ['uses' => $namespacePrefix.'AuthenticatorController@home'])->name(config('mnara.route.prefix') . 'authenticator.index');
    Route::get('/mnara/authenticator/generate', ['uses' => $namespacePrefix.'AuthenticatorController@regenerateSecretKey'])->name(config('mnara.route.prefix') . 'authenticator.generate');
    Route::post('/mnara/authenticator', ['uses' => $namespacePrefix.'AuthenticatorController@home'])->name(config('mnara.route.prefix') . 'authenticator.index');
    /*
    |-------------------------------------------------------------------------
    |	Permission Routes
    |-------------------------------------------------------------------------
    */

    Route::get('permission/role/{role}/edit', $namespacePrefix.'PermissionController@editRole')->name(config('mnara.route.prefix') . 'permission.role.edit');
    Route::post('mnara/permission/role/{role}', $namespacePrefix.'PermissionController@updateRole')->name(config('mnara.route.prefix') . 'permission.role.update');
    Route::resource('mnara/permission', $namespacePrefix.'PermissionController',
        ['names' => [
            'create' => config('mnara.route.prefix') . 'permission.create',
            'destroy' => config('mnara.route.prefix') . 'permission.destroy',
            'edit' => config('mnara.route.prefix') . 'permission.edit',
            'index' => config('mnara.route.prefix') . 'permission.index',
            'show' => config('mnara.route.prefix') . 'permission.show',
            'store' => config('mnara.route.prefix') . 'permission.store',
            'update' => config('mnara.route.prefix') . 'permission.update'
        ]
        ]
    );


    /*
    |-------------------------------------------------------------------------
    |	Role Routes
    |-------------------------------------------------------------------------
    */

    Route::get('mnara/role/matrix', $namespacePrefix.'RoleController@showRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::post('mnara/role/matrix', $namespacePrefix.'RoleController@updateRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::get('mnara/role/permission/{role}/edit', $namespacePrefix.'RoleController@editRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.edit');
    Route::post('mnara/role/permission/{role}', $namespacePrefix.'RoleController@updateRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.update');
    Route::get('mnara/role/user/{role}/edit', $namespacePrefix.'RoleController@editRoleUsers')->name( config('mnara.route.prefix') . 'role.user.edit');
    Route::post('mnara/role/user/{role}', $namespacePrefix.'RoleController@updateRoleUsers')->name( config('mnara.route.prefix') . 'role.user.update');
    Route::resource('mnara/role', $namespacePrefix.'RoleController',
        ['names' => [
            'create'	=> config('mnara.route.prefix') . 'role.create',
            'destroy'	=> config('mnara.route.prefix') . 'role.destroy',
            'edit'		=> config('mnara.route.prefix') . 'role.edit',
            'index'		=> config('mnara.route.prefix') . 'role.index',
            'show'		=> config('mnara.route.prefix') . 'role.show',
            'store'		=> config('mnara.route.prefix') . 'role.store',
            'update'	=> config('mnara.route.prefix') . 'role.update'
        ]
        ]
    );


    /*
    |-------------------------------------------------------------------------
    |	User Routes
    |-------------------------------------------------------------------------
    */

    Route::get('mnara/user/profile/{id}', $namespacePrefix.'UserController@showUserProfile')->name( config('mnara.route.prefix') . 'user.profile');
    Route::get('mnara/user/matrix', $namespacePrefix.'UserController@showUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::post('mnara/user/matrix', $namespacePrefix.'UserController@updateUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::get('mnara/user/role/{user}/edit', $namespacePrefix.'UserController@editUserRoles')->name( config('mnara.route.prefix') . 'user.role.edit');
    Route::post('mnara/user/role/{user}', $namespacePrefix.'UserController@updateUserRoles')->name( config('mnara.route.prefix') . 'user.role.update');
    Route::resource('mnara/user', $namespacePrefix.'UserController',
        ['names' => [
            'create'	=> config('mnara.route.prefix') . 'user.create',
            'destroy'	=> config('mnara.route.prefix') . 'user.destroy',
            'edit'		=> config('mnara.route.prefix') . 'user.edit',
            'index'		=> config('mnara.route.prefix') . 'user.index',
            'show'		=> config('mnara.route.prefix') . 'user.show',
            'store'		=> config('mnara.route.prefix') . 'user.store',
            'update'	=> config('mnara.route.prefix') . 'user.update'
        ]
        ]
    );


    /*
    |-------------------------------------------------------------------------
    |	Mnara Interface Routes
    |-------------------------------------------------------------------------
    */


    Route::get('/', ['uses' => $namespacePrefix.'MnaraController@index', 'as' => 'index']);

});
