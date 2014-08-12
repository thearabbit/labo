<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class CpanelList extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'cpanel-list';
    }

}