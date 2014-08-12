<?php
namespace Rabbit\Labo\Validators;


class CustomerValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'kh_name' => 'required',
            'en_name' => 'required',
            'sex' => 'required',
            'age' => 'required|numeric',
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