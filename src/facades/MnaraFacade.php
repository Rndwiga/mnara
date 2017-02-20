<?php namespace Tyondo\Mnara\Facades;

use Illuminate\Support\Facades\Facade;

class MnaraFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mnara';
    }
}
