<?php
namespace Rabbit\Cpanel\Facades;

use Illuminate\Support\Facades\Facade;

class CharSequence extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'char-sequence';
    }

}