<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class CpanelWidget extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'cpanel-widget';
    }

}