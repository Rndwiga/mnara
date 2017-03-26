<?php

use Illuminate\Database\Seeder;
use Tyondo\Mnara\Traits\Seedable;

class MnaraDummyDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('UserTable');

    }
}
