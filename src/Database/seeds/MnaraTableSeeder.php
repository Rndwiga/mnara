<?php

use Illuminate\Database\Seeder;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;
use Illuminate\Support\Facades\DB;

class MnaraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // roles
        $roles = [
            [ 
                'name'          => 'Super User',
                'slug'          => 'root',
                'description'   => 'Have all access to all areas',
                'special'       => 'all-access',
            ],

            [
                'name'          => 'Administrator',
                'slug'          => 'admin',
                'description'   => 'Some admin area access',
                'special'       => null,
            ],

            [
                'name'          => 'User',
                'slug'          => 'user',
                'description'   => 'No admin access',
                'special'       => null,
            ],

            [
                'name'          => 'Deactivated',
                'slug'          => 'deactivated',
                'description'   => 'Have no access to any areas',
                'special'       => 'no-access',
            ]
        ];
        
        // insert roles
        if(DB::table('roles')->count() <= 0){
            foreach ($roles as $role) {
                DB::table('roles')->insert($role);
            }
        }

         // permissions
        $permissions = [
            [ 
                'name'          => 'Show Mnara Dashboard',
                'slug'          => 'show.mnara.index',
                'description'   => 'View the mnara dashboard shortcuts page'
            ],

            [ 
                'name'          => 'Show user list',
                'slug'          => 'show.user.index',
                'description'   => 'Can show the user list on the index page'
            ],

            [ 
                'name'          => 'Create user',
                'slug'          => 'create.user',
                'description'   => 'Create a user'
            ],

            [ 
                'name'          => 'View user',
                'slug'          => 'show.user',
                'description'   => 'See an individual user info'
            ],

            [ 
                'name'          => 'Edit user',
                'slug'          => 'edit.user',
                'description'   => 'Edit an existing user'
            ],

            [ 
                'name'          => 'Destroy user',
                'slug'          => 'destroy.user',
                'description'   => 'Remove a user permanently'
            ],

            [ 
                'name'          => 'Synchronize users with roles',
                'slug'          => 'sync.user.roles',
                'description'   => 'Used for both the user matrix and user role pages.'
            ],

            [ 
                'name'          => 'User search',
                'slug'          => 'search.user',
                'description'   => 'Able to search users'
            ],

            [ 
                'name'          => 'Show role list',
                'slug'          => 'show.role.index',
                'description'   => 'Can show the role list on the index page'
            ],

            [ 
                'name'          => 'Create role',
                'slug'          => 'create.role',
                'description'   => 'Create a role'
            ],

            [ 
                'name'          => 'View role',
                'slug'          => 'show.role',
                'description'   => 'See an individual role info'
            ],

            [ 
                'name'          => 'Edit role',
                'slug'          => 'edit.role',
                'description'   => 'Edit an existing role'
            ],

            [ 
                'name'          => 'Destroy role',
                'slug'          => 'destroy.role',
                'description'   => 'Remove a role permanently'
            ],

            [ 
                'name'          => 'Synchronize roles with users',
                'slug'          => 'sync.role.users',
                'description'   => 'Syncs a role with multiple users.'
            ],

            [ 
                'name'          => 'Synchronize roles with permissions',
                'slug'          => 'sync.role.permissions',
                'description'   => 'Used for both the role matrix and role permissions pages.'
            ],

            [ 
                'name'          => 'role search',
                'slug'          => 'search.role',
                'description'   => 'Able to search roles'
            ],

            [ 
                'name'          => 'Show permission list',
                'slug'          => 'show.permission.index',
                'description'   => 'Can show the permission list on the index page'
            ],

            [ 
                'name'          => 'Create permission',
                'slug'          => 'create.permission',
                'description'   => 'Create a permission'
            ],

            [ 
                'name'          => 'View permission',
                'slug'          => 'show.permission',
                'description'   => 'See an individual permission info'
            ],

            [ 
                'name'          => 'Edit permission',
                'slug'          => 'edit.permission',
                'description'   => 'Edit an existing permission'
            ],

            [ 
                'name'          => 'Destroy permission',
                'slug'          => 'destroy.permission',
                'description'   => 'Remove a permission permanently'
            ],

            [ 
                'name'          => 'Synchronize permissions with roles',
                'slug'          => 'sync.permission.roles',
                'description'   => 'Syncs a permission with multiple roles.'
            ],

            [ 
                'name'          => 'permission search',
                'slug'          => 'search.permission',
                'description'   => 'Able to search permissions'
            ],
        ];
        if(DB::table('permissions')->count() <= 0){
            //insert permissions
            DB::table('permissions')->insert($permissions);
        }

        // is there a user
        $any = DB::table('users')->count();
        if ( $any < 1) {
            $id = DB::table('users')
                ->insertGetId( [
                        'name' => 'admin',
                        'email' => 'admin@admin.com',
                        'google2fa_secret' => Google2FA::generateSecretKey(config('mnara_authenticator.options.keySize'), config('mnara_authenticator.options.keyPrefix')),
                        'password' => bcrypt('password')
                    ]
                );
            //associate first user with super role
            DB::table('role_user')->insert(
                ['user_id' => $id, 'role_id' => 1]
            );
            $permissions = DB::table('permissions')->get();
            foreach ($permissions as $permission) {
                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id' => 1
                ]);
            }

        }else{
            if(DB::table('role_user')->count() <= 0){
                DB::table('role_user')->insert(
                    ['role_id' => 1, 'user_id'=> 1]
                );
            }

        }
    }
        
}
