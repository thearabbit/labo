<?php
namespace Rabbit\Labo\Validators;


class ProductValidator extends \ValidatorAssistant
{
    protected function before()
    {
        $rules = array(
            'category_id' => 'required',
            'kh_name' => 'required',
            'en_name' => 'required',
            'normal_value' => 'required',
            'price' => 'required|numeric',
            'fee_type' => 'required',
            'fee' => 'required|numeric',
            'child' => 'required',
        );

        $this->inputs['price'] = str_replace(',', '', \Input::get('price'));
        $this->inputs['fee'] = str_replace(',', '', \Input::get('fee'));

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