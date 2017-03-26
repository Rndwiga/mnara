<?php
namespace Tyondo\Mnara\Database\seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultUser extends Seeder
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
                    'email' => 'admin@admin.com',
                    'password' => bcrypt('password')
                ]
            );
    }
}
