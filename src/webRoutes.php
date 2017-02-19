<?php
//Auth::routes();
Route::group( [
   // 'middleware'=> config('mnara.route.middleware'),
    'as'		=> config('mnara.route.as')
], function () {

    /*
    |-------------------------------------------------------------------------
    |	Permission Routes
    |-------------------------------------------------------------------------
    */
    Route::get('mnara/permission/role/{role}/edit', 'PermissionController@editRole')->name( config('mnara.route.prefix') . 'permission.role.edit');
    Route::post('mnara/permission/role/{role}', 'PermissionController@updateRole')->name( config('mnara.route.prefix') . 'permission.role.update');
    Route::resource('mnara/permission', 'PermissionController',
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
    Route::get('mnara/role/matrix', 'RoleController@showRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::post('mnara/role/matrix', 'RoleController@updateRoleMatrix')->name( config('mnara.route.prefix') . 'role.matrix');
    Route::get('mnara/role/permission/{role}/edit', 'RoleController@editRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.edit');
    Route::post('mnara/role/permission/{role}', 'RoleController@updateRolePermissions')->name( config('mnara.route.prefix') . 'role.permission.update');
    Route::get('mnara/role/user/{role}/edit', 'RoleController@editRoleUsers')->name( config('mnara.route.prefix') . 'role.user.edit');
    Route::post('mnara/role/user/{role}', 'RoleController@updateRoleUsers')->name( config('mnara.route.prefix') . 'role.user.update');
    Route::resource('mnara/role', 'RoleController',
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
    Route::get('mnara/user/matrix', 'UserController@showUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::post('mnara/user/matrix', 'UserController@updateUserMatrix')->name( config('mnara.route.prefix') . 'user.matrix');
    Route::get('mnara/user/role/{user}/edit', 'UserController@editUserRoles')->name( config('mnara.route.prefix') . 'user.role.edit');
    Route::post('mnara/user/role/{user}', 'UserController@updateUserRoles')->name( config('mnara.route.prefix') . 'user.role.update');
    Route::resource('mnara/user', 'UserController',
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
    //Route::get('mnara', 'MnaraController@index')->name( config('mnara.route.prefix') . 'index');
    Route::get('mnara', 'Tyondo\Mnara\Controllers\MnaraController@index')->name( config('mnara.route.prefix') . 'index');

});