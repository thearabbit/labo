<?php
namespace Rabbit\Labo\Facades;

use Illuminate\Support\Facades\Facade;

class LaboWidget extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'labo-widget';
    }

}