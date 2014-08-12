<?php
namespace Rabbit\Labo\Validators;


class ProductChildValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'product_id' => 'required',
            'kh_name' => 'required',
            'en_name' => 'required',
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