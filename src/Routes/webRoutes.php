<?php
//Auth::routes();
Route::any('/home', ['uses' => 'Tyondo\Mnara\Controllers\AuthenticatorController@home']);
Route::group( [
    'middleware'=> config('mnara.route.middleware'),
    'as'		=> config('mnara.route.as')
], function () {

    /*
    |-------------------------------------------------------------------------
    |	Permission Routes
    |-------------------------------------------------------------------------
    */
    Route::get('mnara/permission/role/{role}/edit', 'Tyondo\Mnara\Controllers\PermissionController@editRole')->name( config('mnara.route.prefix') . 'permission.role.edit');
    Route::post('mnara/permission/role/{role}', 'Tyondo\Mnara\Controllers\PermissionController@updateRole')->name( config('mnara.route.prefix') . 'permission.role.update');
    Route::resource('mnara/permission', 'Tyondo\Mnara\Controllers\PermissionController',
        ['names' => [
            'create'	=> config('mnara.route.prefix') . 'permission.create',
            'destroy'	=> config('mnara.route.prefix') . 'permission.destroy',
            'edit'		=> config('mnara.route.prefix') . 'permission.edit',
            'index'		=> config('mnara.route.prefix') . 'permission.index',
            'show'		=> config('mnara.route.prefix') . 'permission.show',
            'store'		=> config('mnara.route.prefix') . 'permission.store',
            'update'	=> config('mnara.route.prefix') . 'permission.update'
        ]
        ]
    );


    /*
    |-------------------------------------------------------------------------
    |	Role Routes
    |-------------------------------------------------------------------------
    */
    Route::get('mnara/role/matrix', 'Tyondo\Mnara\Controllers\RoleController@showRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::post('mnara/role/matrix', 'Tyondo\Mnara\Controllers\RoleController@updateRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::get('mnara/role/permission/{role}/edit', 'Tyondo\Mnara\Controllers\RoleController@editRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.edit');
    Route::post('mnara/role/permission/{role}', 'Tyondo\Mnara\Controllers\RoleController@updateRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.update');
    Route::get('mnara/role/user/{role}/edit', 'Tyondo\Mnara\Controllers\RoleController@editRoleUsers')->name( config('mnara.route.prefix') . 'role.user.edit');
    Route::post('mnara/role/user/{role}', 'Tyondo\Mnara\Controllers\RoleController@updateRoleUsers')->name( config('mnara.route.prefix') . 'role.user.update');
    Route::resource('mnara/role', 'Tyondo\Mnara\Controllers\RoleController',
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
    Route::get('mnara/user/matrix', 'Tyondo\Mnara\Controllers\UserController@showUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::post('mnara/user/matrix', 'Tyondo\Mnara\Controllers\UserController@updateUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::get('mnara/user/role/{user}/edit', 'Tyondo\Mnara\Controllers\UserController@editUserRoles')->name( config('mnara.route.prefix') . 'user.role.edit');
    Route::post('mnara/user/role/{user}', 'Tyondo\Mnara\Controllers\UserController@updateUserRoles')->name( config('mnara.route.prefix') . 'user.role.update');
    Route::resource('mnara/user', 'Tyondo\Mnara\Controllers\UserController',
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
    Route::get('mnara', 'Tyondo\Mnara\Controllers\MnaraController@index')->name( config('mnara.route.prefix') . 'index');

});