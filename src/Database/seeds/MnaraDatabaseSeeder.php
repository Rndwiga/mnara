<?php
#namespace Tyondo\Mnara\Database\seeds;

use Illuminate\Database\Seeder;
use Tyondo\Mnara\Traits\Seedable;

class MnaraDatabaseSeeder extends Seeder
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
        $this->seed('MnaraTableSeeder');

    }
}
