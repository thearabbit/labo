<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class PageProperty extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'page-property';
    }

}