<?php
namespace Rabbit\Labo\Validators;


class CategoryValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'kh_name' => 'required',
            'en_name' => 'required',
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