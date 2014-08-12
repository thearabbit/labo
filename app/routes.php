<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get(
    'test',
    array(
        'as' => 'test',
        'uses' =>
            function () {

                $data = new stdClass();
                $data->field = array(
                    0 => 'a',
                    1 => 'b',
                    2 => 'c',
                );
                return $data->field[0];

            }
    )
);
