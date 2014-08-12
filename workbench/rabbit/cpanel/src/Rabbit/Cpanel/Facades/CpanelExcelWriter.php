<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class CpanelExcelWriter extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'cpanel-excel-writer';
    }

}