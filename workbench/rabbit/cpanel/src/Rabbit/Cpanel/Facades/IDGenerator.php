<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class IDGenerator extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'id-generator';
    }

}