<?php
namespace Rabbit\Labo\Validators;


class StaffValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'kh_name' => 'required',
            'en_name' => 'required',
            'sex' => 'required',
            'dob' => 'required',
            'status' => 'required',
            'position' => 'required',
            'address' => 'required',
            'telephone' => 'required',
        );

        $this->rules = $rules;
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Rule
    |--------------------------------------------------------------------------
    */
    protected function customRule($attribute, $value, $parameters)
    {
        //
    }
}