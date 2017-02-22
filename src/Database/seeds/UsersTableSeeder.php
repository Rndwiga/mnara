<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert( [
                    'name' => 'admin',
                    'email' => 'admin@change.me',
                    'password' => bcrypt('password'),
                    'google2fa_secret' => Google2FA::generateSecretKey(config('authenticator.options.keySize'), config('authenticator.options.keyPrefix'))
                ]
            );
    }
}