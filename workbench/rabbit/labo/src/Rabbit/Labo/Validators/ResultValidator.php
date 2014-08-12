<?php
namespace Rabbit\Labo\Validators;


class ResultValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'product_id' => 'required',
            'normal_value' => 'required',
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