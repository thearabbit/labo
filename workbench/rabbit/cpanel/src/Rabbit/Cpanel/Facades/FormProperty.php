<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class FormProperty extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'form-property';
    }

}