<?php

namespace Laravel\Stagebox\Facades;

use Illuminate\Support\Facades\Facade;

class Stagebox extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'stagebox';
    }
}
