<?php
namespace Rabbit\Labo\Facades;

use Illuminate\Support\Facades\Facade;

class LaboList extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'labo-list';
    }

}